<?php

namespace App\Http\Controllers\admin;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::all();
        return view('pageadmin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pageadmin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengumuman' => 'required|string|max:255',
            'jenis_pengumuman' => 'required|string',
            'konten_pengumuman' => 'required|string',
            'gambar_pengumuman' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['nama_pengumuman', 'jenis_pengumuman', 'konten_pengumuman']);

        if ($request->hasFile('gambar_pengumuman')) {
            $gambar = $request->file('gambar_pengumuman');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('pengumuman'), $namaGambar);
            $data['gambar_pengumuman'] = $namaGambar;
        }

        Pengumuman::create($data);
        Alert::success('Sukses', 'Data pengumuman berhasil ditambahkan');
        return redirect()->route('master-pengumuman.index');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pageadmin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengumuman' => 'required|string|max:255',
            'jenis_pengumuman' => 'required|string',
            'konten_pengumuman' => 'required|string',
            'gambar_pengumuman' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $data = $request->only(['nama_pengumuman', 'jenis_pengumuman', 'konten_pengumuman']);

        if ($request->hasFile('gambar_pengumuman')) {
            // Hapus gambar lama jika ada
            if ($pengumuman->gambar_pengumuman && file_exists(public_path('pengumuman/' . $pengumuman->gambar_pengumuman))) {
                @unlink(public_path('pengumuman/' . $pengumuman->gambar_pengumuman));
            }
            $gambar = $request->file('gambar_pengumuman');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('pengumuman'), $namaGambar);
            $data['gambar_pengumuman'] = $namaGambar;
        }

        $pengumuman->update($data);
        Alert::success('Sukses', 'Data pengumuman berhasil diubah');
        return redirect()->route('master-pengumuman.index');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        // Hapus file gambar jika ada
        if ($pengumuman->gambar_pengumuman && file_exists(public_path('pengumuman/' . $pengumuman->gambar_pengumuman))) {
            @unlink(public_path('pengumuman/' . $pengumuman->gambar_pengumuman));
        }
        $pengumuman->delete();
        Alert::success('Sukses', 'Data pengumuman berhasil dihapus');
        return redirect()->route('master-pengumuman.index');
    }

    public function show($nama_pengumuman)
    {
        $pengumuman = Pengumuman::where('nama_pengumuman', $nama_pengumuman)->firstOrFail();
        return view('pageadmin.pengumuman.show', compact('pengumuman'));
    }


}