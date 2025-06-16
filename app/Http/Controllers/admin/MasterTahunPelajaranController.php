<?php

namespace App\Http\Controllers\admin;

use App\Models\MasterTahunPelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class MasterTahunPelajaranController extends Controller
{
    public function index()
    {
        $tahunPelajaran = MasterTahunPelajaran::all();
        return view('pageadmin.master_tahunpelajaran.index', compact('tahunPelajaran'));
    }

    public function create()
    {
        return view('pageadmin.master_tahunpelajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_pelajaran' => 'required|string|max:255',
        ]);

        MasterTahunPelajaran::create($request->all());
        Alert::success('Sukses', 'Data tahun pelajaran berhasil ditambahkan');
        return redirect()->route('master-tahun-pelajaran.index');
    }

    public function edit($id)
    {
        $tahunPelajaran = MasterTahunPelajaran::findOrFail($id);
        return view('pageadmin.master_tahunpelajaran.edit', compact('tahunPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_pelajaran' => 'required|string|max:255',
        ]);

        $tahunPelajaran = MasterTahunPelajaran::findOrFail($id);
        $tahunPelajaran->update($request->all());
        
        Alert::success('Sukses', 'Data tahun pelajaran berhasil diperbarui');
        return redirect()->route('master-tahun-pelajaran.index');
    }

    public function destroy($id)
    {
        $tahunPelajaran = MasterTahunPelajaran::findOrFail($id);
        $tahunPelajaran->delete();
        
        Alert::success('Sukses', 'Data tahun pelajaran berhasil dihapus');
        return redirect()->route('master-tahun-pelajaran.index');
    }
}
