<?php

namespace App\Http\Controllers\admin;

use App\Models\KepalaSekolah;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class KepalaSekolahController extends Controller
{
  public function index()
  {
    $kepalaSekolah = KepalaSekolah::with('user')->get();
    return view('pageadmin.master_kepalasekolah.index', compact('kepalaSekolah'));
  }

  public function create()
  {
    return view('pageadmin.master_kepalasekolah.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_kepala_sekolah' => 'required',
      'nuptk' => 'required',
      'nip' => 'required',
      'email' => 'required|email|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);

    // Buat user baru
    $user = User::create([
      'nama' => $request->nama_kepala_sekolah,
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => 'kepala_sekolah'
    ]);

    // Buat kepala sekolah baru
    KepalaSekolah::create([
      'user_id' => $user->id,
      'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip
    ]);

    Alert::success('Berhasil', 'Data Kepala Sekolah berhasil ditambahkan');
    return redirect()->route('kepala-sekolah.index');
  }

  public function show($id)
  {
    $kepalaSekolah = KepalaSekolah::with('user')->findOrFail($id);
    return view('pageadmin.master_kepalasekolah.show', compact('kepalaSekolah'));
  }

  public function edit($id)
  {
    $kepalaSekolah = KepalaSekolah::with('user')->findOrFail($id);
    $user = User::find($kepalaSekolah->user_id);
    return view('pageadmin.master_kepalasekolah.edit', compact('kepalaSekolah', 'user'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama_kepala_sekolah' => 'required',
      'nuptk' => 'required',
      'nip' => 'required',
      'username' => 'required|unique:users,username,' . $request->user_id,
      'email' => 'required|email|unique:users,email,' . $request->user_id,
    ]);

    $kepalaSekolah = KepalaSekolah::findOrFail($id);
    
    // Update data user
    $user = User::find($kepalaSekolah->user_id);
    $user->update([
      'nama' => $request->nama_kepala_sekolah,
      'username' => $request->username,
      'email' => $request->email,
    ]);

    // Update password jika diisi
    if ($request->filled('password')) {
      $user->update([
        'password' => Hash::make($request->password)
      ]);
    }

    // Update data wali kelas
    $kepalaSekolah->update([
      'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip
    ]);

    Alert::success('Berhasil', 'Data Kepala Sekolah berhasil diperbarui');
    return redirect()->route('kepala-sekolah.index');
  }

  public function destroy($id)
  {
    $kepalaSekolah = KepalaSekolah::findOrFail($id);
    $user = User::find($kepalaSekolah->user_id);
    
    $kepalaSekolah->delete();
    $user->delete();

    Alert::success('Berhasil', 'Data Kepala Sekolah berhasil dihapus');
    return redirect()->route('kepala-sekolah.index');
  }
}

