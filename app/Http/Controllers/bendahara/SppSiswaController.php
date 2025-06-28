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


class SppSiswaController extends Controller
{
   public function index()
   {
    $data = SppSiswa::with('siswa' , 'tahunPelajaran')->get();
    return view('pagebendahara.spp.index', compact('data'));
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
        
        if ($target) {
            $token = WhatsappApi::first()->access_token;
            $message = "Assalamu'alaikum Wr. Wb.\n\nData pembayaran SPP untuk anak Bapak/Ibu {$siswa->nama_anak} telah diperbarui:\nBulan: {$request->bulan_bayar}\nJumlah: Rp {$request->jumlah_bayar}\nTanggal: {$request->tanggal_bayar}\n\nTerima kasih.";
            
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

    $spp = SppSiswa::create($request->all());
    
    // Ambil data siswa dan orang tua/wali untuk notifikasi
    $siswa = Siswa::with('orangTuaWali')->find($request->siswa_id);
    
    if ($siswa && $siswa->orangTuaWali) {
        $target = $siswa->orangTuaWali->no_wa_ortu ?? $siswa->orangTuaWali->no_wa_wali;
        
        if ($target) {
            $token = WhatsappApi::first()->access_token;
            $message = "Assalamu'alaikum Wr. Wb.\n\nAnak Bapak/Ibu {$siswa->nama_anak} telah melakukan pembayaran SPP untuk bulan {$request->bulan_bayar}.\nJumlah: Rp {$request->jumlah_bayar}\nTanggal: {$request->tanggal_bayar}\n\nTerima kasih.";
            
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
    $siswa = Siswa::where('nama_anak', $nama_anak)->with('masterKelas')->first();
    
    if (!$siswa) {
        Alert::error('Error', 'Data siswa tidak ditemukan');
        return redirect()->back();
    }

    $spp = SppSiswa::with('tahunPelajaran')
        ->where('siswa_id', $siswa->id)
        ->first();

    if (!$spp) {
        Alert::error('Error', 'Data SPP tidak ditemukan');
        return redirect()->back();
    }

    return view('pagebendahara.spp.kartu_pembayaran', compact('spp', 'siswa'));
   }

  
}
