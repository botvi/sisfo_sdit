<?php

namespace App\Http\Controllers\bendahara;

use App\Models\SppSiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\MasterTahunPelajaran;
use App\Models\WhatsappApi;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\MasterKelas;
use App\Models\User;


class SppSiswaController extends Controller
{
   public function index(Request $request)
   {
    $query = SppSiswa::with(['siswa.masterKelas', 'tahunPelajaran']);
    
    // Filter berdasarkan kelas
    if ($request->filled('kelas_id')) {
        $query->whereHas('siswa', function($q) use ($request) {
            $q->where('master_kelas_id', $request->kelas_id);
        });
    }
    
    // Filter berdasarkan nama siswa
    if ($request->filled('nama_siswa')) {
        $query->whereHas('siswa', function($q) use ($request) {
            $q->where('nama_anak', 'like', '%' . $request->nama_siswa . '%');
        });
    }
    
    // Filter berdasarkan tahun pelajaran
    if ($request->filled('tahun_pelajaran_id')) {
        $query->where('tahun_pelajaran_id', $request->tahun_pelajaran_id);
    }
    
    $data = $query->get();
    
    // Data untuk dropdown filter
    $kelas = MasterKelas::all();
    $tahunPelajaran = MasterTahunPelajaran::all();
    
    return view('pagebendahara.spp.index', compact('data', 'kelas', 'tahunPelajaran'));
   }

   public function create()
   {
    $siswa = Siswa::all();
    $tahunPelajaran = MasterTahunPelajaran::all();
    return view('pagebendahara.spp.create', compact('siswa', 'tahunPelajaran'));
   }

   public function edit($id)
   {
    $spp = SppSiswa::findOrFail($id);
    $siswa = Siswa::all();
    $tahunPelajaran = MasterTahunPelajaran::all();
    return view('pagebendahara.spp.edit', compact('spp', 'siswa', 'tahunPelajaran'));
   }

   public function update(Request $request, $id)
   {
    $request->validate([
        'siswa_id' => 'required|exists:siswas,id',
        'tanggal_bayar' => 'required|date',
        'bulan_bayar' => 'required|string',
        'jumlah_bayar' => 'required|numeric',
        'tahun_pelajaran_id' => 'required|exists:master_tahun_pelajarans,id',
        'status_bayar' => 'required|string',
    ]);

    $spp = SppSiswa::findOrFail($id);
    $spp->update($request->all());

    // Ambil data siswa dan orang tua/wali untuk notifikasi
    $siswa = Siswa::with('orangTuaWali')->find($request->siswa_id);
    
    if ($siswa && $siswa->orangTuaWali) {
        $target = $siswa->orangTuaWali->no_wa_ortu ?? $siswa->orangTuaWali->no_wa_wali;

        $statusText = $request->status_bayar === 'lunas' ? 'Lunas' : 'Belum lunas';
        if ($target) {
                $token = WhatsappApi::first()->access_token;
            $message = "Assalamu'alaikum Wr. Wb.\n\nData pembayaran SPP untuk anak Bapak/Ibu {$siswa->nama_anak} telah diperbarui:\nBulan: {$request->bulan_bayar}\nJumlah: Rp {$request->jumlah_bayar}\nTanggal: {$request->tanggal_bayar}\nDinyatakan: {$statusText}\n\nTerima kasih.";
            
            Http::withoutVerifying()->get('https://api.fonnte.com/send', [
                'token' => $token,
                'target' => $target,
                'message' => $message,
            ]);
        }
    }

    Alert::success('Berhasil', 'Data berhasil diperbarui');
    return redirect()->route('spp.index');
   }

   public function store(Request $request)
   {
    $request->validate([
        'siswa_id' => 'required|exists:siswas,id',
        'tanggal_bayar' => 'required|date',
        'bulan_bayar' => 'required|string',
        'jumlah_bayar' => 'required|numeric',
        'tahun_pelajaran_id' => 'required|exists:master_tahun_pelajarans,id',
        'status_bayar' => 'required|string',
    ]);

    // Cek apakah sudah ada pembayaran untuk siswa, bulan, dan tahun pelajaran yang sama
    $existingPayment = SppSiswa::where('siswa_id', $request->siswa_id)
        ->where('bulan_bayar', $request->bulan_bayar)
        ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
        ->first();

    if ($existingPayment) {
        Alert::warning('Peringatan', 'Siswa ini sudah ada pembayaran pada bulan ' . $request->bulan_bayar . ' tahun pelajaran ini. Jika ada perubahan pembayaran atau pelunasan angsuran, silahkan edit data yang sudah ada.');
        return redirect()->back()->withInput();
    }

    $spp = SppSiswa::create($request->all());
    
    // Ambil data siswa dan orang tua/wali untuk notifikasi
    $siswa = Siswa::with('orangTuaWali')->find($request->siswa_id);
    
    if ($siswa && $siswa->orangTuaWali) {
        $target = $siswa->orangTuaWali->no_wa_ortu ?? $siswa->orangTuaWali->no_wa_wali;
        
        if ($target) {
            $token = WhatsappApi::first()->access_token;
            $statusText = $request->status_bayar === 'lunas' ? 'Lunas' : 'Belum lunas';
            $message = "Assalamu'alaikum Wr. Wb.\n\nAnak Bapak/Ibu {$siswa->nama_anak}, {$statusText} melakukan pembayaran SPP untuk bulan {$request->bulan_bayar}.\nJumlah: Rp {$request->jumlah_bayar}\nTanggal: {$request->tanggal_bayar}\n\nTerima kasih.";
            
            Http::withoutVerifying()->get('https://api.fonnte.com/send', [
                'token' => $token,
                'target' => $target,
                'message' => $message,
            ]);
        }
    }

    Alert::success('Berhasil', 'Data berhasil ditambahkan');
    return redirect()->route('spp.index');
   }

   
   public function destroy($id)
   {
    $spp = SppSiswa::find($id);
    $spp->delete();
    Alert::success('Berhasil', 'Data berhasil dihapus');
    return redirect()->route('spp.index');
   }

   public function kirimPesanBelumBayar()
   {
    // Ambil bulan kemarin berdasarkan tanggal_bayar
    $bulanKemarin = Carbon::now()->subMonth();
    $bulanKemarinIndonesia = $this->konversiBulanIndonesia($bulanKemarin->format('F Y'));
    
    // Ambil semua siswa yang aktif
    $semuaSiswa = Siswa::with('orangTuaWali')->get();
    
    // Ambil siswa yang sudah bayar bulan kemarin berdasarkan tanggal_bayar dan bulan_bayar
    $siswaSudahBayar = SppSiswa::where(function($query) use ($bulanKemarin) {
            $query->whereYear('tanggal_bayar', $bulanKemarin->year)
                  ->whereMonth('tanggal_bayar', $bulanKemarin->month);
        })
        ->orWhere('bulan_bayar', $bulanKemarinIndonesia)
        ->pluck('siswa_id')
        ->toArray();
    
    // Filter siswa yang belum bayar
    $siswaBelumBayar = $semuaSiswa->whereNotIn('id', $siswaSudahBayar);
    
    $token = WhatsappApi::first()->access_token;
    $pesanTerkirim = 0;
    $pesanGagal = 0;
    
    foreach ($siswaBelumBayar as $siswa) {
        if ($siswa->orangTuaWali) {
            $target = $siswa->orangTuaWali->no_wa_ortu ?? $siswa->orangTuaWali->no_wa_wali;
            
            if ($target) {
                $message = "Assalamu'alaikum Wr. Wb.\n\nMohon maaf, kami ingin mengingatkan bahwa pembayaran SPP untuk anak Bapak/Ibu {$siswa->nama_anak} untuk bulan {$bulanKemarinIndonesia} belum dilakukan.\n\nMohon segera melakukan pembayaran untuk menghindari keterlambatan.\n\nTerima kasih atas perhatiannya.";
                
                try {
                    $response = Http::withoutVerifying()->get('https://api.fonnte.com/send', [
                        'token' => $token,
                        'target' => $target,
                        'message' => $message,
                    ]);
                    
                    if ($response->successful()) {
                        $pesanTerkirim++;
                    } else {
                        $pesanGagal++;
                    }
                } catch (\Exception $e) {
                    $pesanGagal++;
                }
                
                // Delay untuk menghindari rate limiting
                sleep(1);
            }
        }
    }
    
    $totalSiswa = $siswaBelumBayar->count();
    $message = "Pesan pengingatan telah dikirim ke {$pesanTerkirim} orang tua dari {$totalSiswa} siswa yang belum membayar SPP bulan {$bulanKemarinIndonesia}. Pesan gagal: {$pesanGagal}";
    
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => [
            'total_siswa' => $totalSiswa,
            'pesan_terkirim' => $pesanTerkirim,
            'pesan_gagal' => $pesanGagal,
            'bulan' => $bulanKemarinIndonesia
        ]
    ]);
   }

   private function konversiBulanIndonesia($bulanInggris)
   {
    $bulan = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];
    
    foreach ($bulan as $en => $id) {
        $bulanInggris = str_replace($en, $id, $bulanInggris);
    }
    
    return $bulanInggris;
   }

   public function kartuSpp($nama_anak)
   {
    // Decode URL parameter
    $nama_anak = urldecode($nama_anak);
    $siswa = Siswa::where('nama_anak', $nama_anak)->with('masterKelas')->first();
    $kepalaSekolah = User::where('role', 'kepala_sekolah')->first();
    $bendahara = User::where('role', 'bendahara')->first();
    if (!$siswa) {
        Alert::error('Error', 'Data siswa tidak ditemukan');
        return redirect()->back();
    }

    $sppData = SppSiswa::with('tahunPelajaran')
        ->where('siswa_id', $siswa->id)
        ->where('status_bayar', 'lunas')
        ->orderBy('tahun_pelajaran_id', 'asc')
        ->orderBy('bulan_bayar', 'asc')
        ->get();

    if ($sppData->isEmpty()) {
        Alert::error('Error', 'Data SPP tidak ditemukan');
        return redirect()->back();
    }

    // Ambil tahun pelajaran terbaru untuk header
    $tahunPelajaran = $sppData->last()->tahunPelajaran;

    return view('pagebendahara.spp.kartu_pembayaran', compact('sppData', 'siswa', 'tahunPelajaran', 'kepalaSekolah', 'bendahara'));
   }

  
}
