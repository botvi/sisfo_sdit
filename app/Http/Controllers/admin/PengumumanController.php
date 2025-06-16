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
        ]);

        Pengumuman::create($request->all());
        Alert::success('Sukses', 'Data pengumuman berhasil ditambahkan');
        return redirect()->route('pengumuman.index');
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
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update($request->all());
        Alert::success('Sukses', 'Data pengumuman berhasil diubah');
        return redirect()->route('pengumuman.index');
        }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        Alert::success('Sukses', 'Data pengumuman berhasil dihapus');
        return redirect()->route('pengumuman.index');
    }

    public function show($nama_pengumuman)
    {
        $pengumuman = Pengumuman::where('nama_pengumuman', $nama_pengumuman)->firstOrFail();
        return view('pageadmin.pengumuman.show', compact('pengumuman'));
    }


}