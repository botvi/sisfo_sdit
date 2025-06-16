<?php

namespace App\Http\Controllers\wali_kelas;

use App\Models\OrangTuaWali;
use App\Models\Siswa;
use App\Models\MasterKelas;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrangTuaWalidanSiswaController extends Controller
{
    public function index()
    {
        // Mendapatkan wali kelas berdasarkan user yang login
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        
        // Mendapatkan siswa yang berada di kelas yang diampu oleh wali kelas tersebut
        $siswa = Siswa::with('orangTuaWali', 'masterKelas')
            ->whereHas('masterKelas', function($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            })
            ->get();
            
        return view('pagewalikelas.orang_tua_wali_dan_siswa.index', compact('siswa'));
    }

    public function create()
    {
        $masterKelas = MasterKelas::all();
        return view('pagewalikelas.orang_tua_wali_dan_siswa.create', compact('masterKelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ibu' => 'required',
            'nik_ibu' => 'required|numeric|digits:16',
            'nama_ayah' => 'required',
            'nik_ayah' => 'required|numeric|digits:16', 
            'alamat_ortu' => 'required',
            'no_wa_ortu' => 'required|numeric',
            'nama_wali' => 'nullable',
            'nik_wali' => 'nullable|numeric|digits:16',
            'alamat_wali' => 'nullable',
            'no_wa_wali' => 'nullable|numeric',
            'nama_anak' => 'required',
            'jenis_kelamin' => 'required',
            'nik_anak' => 'required|numeric|digits:16',
            'master_kelas_id' => 'required|exists:master_kelas,id',
            'nis' => 'required|numeric',
            'nisn' => 'required|numeric|digits:10'
        ]);

        // Simpan data orang tua/wali
        $orangTuaWali = OrangTuaWali::create([
            'nama_ibu' => $request->nama_ibu,
            'nik_ibu' => $request->nik_ibu,
            'nama_ayah' => $request->nama_ayah,
            'nik_ayah' => $request->nik_ayah,
            'alamat_ortu' => $request->alamat_ortu,
            'no_wa_ortu' => $request->no_wa_ortu,
            'nama_wali' => $request->nama_wali,
            'nik_wali' => $request->nik_wali,
            'alamat_wali' => $request->alamat_wali,
            'no_wa_wali' => $request->no_wa_wali
        ]);

        // Simpan data siswa
        $siswa = Siswa::create([
            'nama_anak' => $request->nama_anak,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik_anak' => $request->nik_anak,
            'master_kelas_id' => $request->master_kelas_id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'orang_tua_wali_id' => $orangTuaWali->id
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->route('orang-tua-wali-dan-siswa.index');
    }

    public function edit($id)
    {
        $data = Siswa::with('orangTuaWali')->findOrFail($id);
        $masterKelas = MasterKelas::all();
        return view('pagewalikelas.orang_tua_wali_dan_siswa.edit', compact('data', 'masterKelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ibu' => 'required',
            'nik_ibu' => 'required|numeric|digits:16',
            'nama_ayah' => 'required',
            'nik_ayah' => 'required|numeric|digits:16', 
            'alamat_ortu' => 'required',
            'no_wa_ortu' => 'required|numeric',
            'nama_wali' => 'nullable',
            'nik_wali' => 'nullable|numeric|digits:16',
            'alamat_wali' => 'nullable',
            'no_wa_wali' => 'nullable|numeric',
            'nama_anak' => 'required',
            'jenis_kelamin' => 'required',
            'nik_anak' => 'required|numeric|digits:16',
            'master_kelas_id' => 'required|exists:master_kelas,id',
            'nis' => 'required|numeric',
            'nisn' => 'required|numeric|digits:10'
        ]);

        $siswa = Siswa::with('orangTuaWali')->findOrFail($id);
        
        // Update data orang tua/wali
        $siswa->orangTuaWali->update([
            'nama_ibu' => $request->nama_ibu,
            'nik_ibu' => $request->nik_ibu,
            'nama_ayah' => $request->nama_ayah,
            'nik_ayah' => $request->nik_ayah,
            'alamat_ortu' => $request->alamat_ortu,
            'no_wa_ortu' => $request->no_wa_ortu,
            'nama_wali' => $request->nama_wali,
            'nik_wali' => $request->nik_wali,
            'alamat_wali' => $request->alamat_wali,
            'no_wa_wali' => $request->no_wa_wali
        ]);

        // Update data siswa
        $siswa->update([
            'nama_anak' => $request->nama_anak, 
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik_anak' => $request->nik_anak,
            'master_kelas_id' => $request->master_kelas_id,
            'nis' => $request->nis,
            'nisn' => $request->nisn
        ]); 

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->route('orang-tua-wali-dan-siswa.index');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        $orangTuaWali = OrangTuaWali::findOrFail($siswa->orang_tua_wali_id);
        $orangTuaWali->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('orang-tua-wali-dan-siswa.index');
    }
}