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
