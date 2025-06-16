<?php

namespace App\Http\Controllers\admin;

use App\Models\WaliKelas;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class WaliKelasController extends Controller
{
  public function index()
  {
    $waliKelas = WaliKelas::with('user')->get();
    return view('pageadmin.master_walikelas.index', compact('waliKelas'));
  }

  public function create()
  {
    return view('pageadmin.master_walikelas.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_wali_kelas' => 'required',
      'nuptk' => 'required',
      'nip' => 'required',
      'email' => 'required|email|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);

    // Buat user baru
    $user = User::create([
      'nama' => $request->nama_wali_kelas,
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => 'wali_kelas'
    ]);

    // Buat wali kelas baru
    WaliKelas::create([
      'user_id' => $user->id,
      'nama_wali_kelas' => $request->nama_wali_kelas,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip
    ]);

    Alert::success('Berhasil', 'Data Wali Kelas berhasil ditambahkan');
    return redirect()->route('wali-kelas.index');
  }

  public function show($id)
  {
    $waliKelas = WaliKelas::with('user')->findOrFail($id);
    return view('pageadmin.master_walikelas.show', compact('waliKelas'));
  }

  public function edit($id)
  {
    $waliKelas = WaliKelas::with('user')->findOrFail($id);
    $user = User::find($waliKelas->user_id);
    return view('pageadmin.master_walikelas.edit', compact('waliKelas', 'user'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama_wali_kelas' => 'required',
      'nuptk' => 'required',
      'nip' => 'required',
      'username' => 'required|unique:users,username,' . $request->user_id,
      'email' => 'required|email|unique:users,email,' . $request->user_id,
    ]);

    $waliKelas = WaliKelas::findOrFail($id);
    
    // Update data user
    $user = User::find($waliKelas->user_id);
    $user->update([
      'nama' => $request->nama_wali_kelas,
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
    $waliKelas->update([
      'nama_wali_kelas' => $request->nama_wali_kelas,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip
    ]);

    Alert::success('Berhasil', 'Data Wali Kelas berhasil diperbarui');
    return redirect()->route('wali-kelas.index');
  }

  public function destroy($id)
  {
    $waliKelas = WaliKelas::findOrFail($id);
    $user = User::find($waliKelas->user_id);
    
    $waliKelas->delete();
    $user->delete();

    Alert::success('Berhasil', 'Data Wali Kelas berhasil dihapus');
    return redirect()->route('wali-kelas.index');
  }
}

