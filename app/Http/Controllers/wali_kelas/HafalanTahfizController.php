<?php

namespace App\Http\Controllers\wali_kelas;

use App\Models\HafalanTahfiz;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Models\WhatsappApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HafalanTahfizController extends Controller
{
    public function index()
    {
        // Mendapatkan wali kelas berdasarkan user yang login
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        
        // Mendapatkan data hafalan untuk siswa di kelas yang diampu
        $data = HafalanTahfiz::with(['siswa.masterKelas'])
            ->whereHas('siswa.masterKelas', function ($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            })
            ->get();
            
        return view('pagewalikelas.hafalan_tahfiz.index', compact('data'));
    }

    public function create()
    {
        // Mendapatkan wali kelas berdasarkan user yang login
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();

        // Mendapatkan siswa yang berada di kelas yang diampu oleh wali kelas tersebut
        $siswa = Siswa::with('orangTuaWali', 'masterKelas')
            ->whereHas('masterKelas', function ($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            })
            ->get();
        return view('pagewalikelas.hafalan_tahfiz.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_hafalan' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        // Validasi bahwa siswa berada di kelas yang diampu wali kelas
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        $siswa = Siswa::with('masterKelas')->findOrFail($request->siswa_id);
        
        if ($siswa->masterKelas->wali_kelas_id !== $waliKelas->id) {
            Alert::error('Error', 'Anda tidak memiliki akses untuk menambahkan hafalan siswa ini');
            return redirect()->back();
        }

        $hafalanTahfiz = HafalanTahfiz::create([
            'siswa_id' => $request->siswa_id,
            'tanggal_hafalan' => $request->tanggal_hafalan,
            'keterangan' => $request->keterangan
        ]);

        // Kirim notifikasi WhatsApp
        $siswa = Siswa::with('orangTuaWali')->find($request->siswa_id);
        if ($siswa && $siswa->orangTuaWali) {
            $target = $siswa->orangTuaWali->no_wa_ortu ?? $siswa->orangTuaWali->no_wa_wali;
            
            if ($target) {
                $token = WhatsappApi::first()->access_token;
                $message = "Assalamu'alaikum Wr. Wb.\n\nAnak Bapak/Ibu {$siswa->nama_anak} telah melakukan hafalan pada tanggal {$request->tanggal_hafalan}.\n\nKeterangan: {$request->keterangan}\n\nTerima kasih.";

                Http::withoutVerifying()->get('https://api.fonnte.com/send', [
                    'token' => $token,
                    'target' => $target,
                    'message' => $message,
                ]);
            }
        }

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->route('hafalan-tahfiz.index');
    }

    
    public function destroy($id)
    {
        // Validasi bahwa hafalan yang akan dihapus adalah milik siswa di kelas yang diampu
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        $hafalanTahfiz = HafalanTahfiz::with(['siswa.masterKelas'])->findOrFail($id);
        
        if ($hafalanTahfiz->siswa->masterKelas->wali_kelas_id !== $waliKelas->id) {
            Alert::error('Error', 'Anda tidak memiliki akses untuk menghapus hafalan ini');
            return redirect()->route('hafalan-tahfiz.index');
        }

        $hafalanTahfiz->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('hafalan-tahfiz.index');
    }
}
