<?php

namespace App\Http\Controllers\admin;

use App\Models\Bendahara;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class BendaharaController extends Controller
{
  public function index()
  {
    $bendahara = Bendahara::with('user')->get();
    return view('pageadmin.master_bendahara.index', compact('bendahara'));
  }

  public function create()
  {
    return view('pageadmin.master_bendahara.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_bendahara' => 'required',
      'nuptk' => 'required',
      'nip' => 'required',
      'email' => 'required|email|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);

    // Buat user baru
    $user = User::create([
      'nama' => $request->nama_bendahara,
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => 'bendahara'
    ]);

    // Buat wali kelas baru
    Bendahara::create([
      'user_id' => $user->id,
      'nama_bendahara' => $request->nama_bendahara,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip
    ]);

    Alert::success('Berhasil', 'Data Bendahara berhasil ditambahkan');
    return redirect()->route('bendahara.index');
  }

  public function show($id)
  {
    $bendahara = Bendahara::with('user')->findOrFail($id);
    return view('pageadmin.master_bendahara.show', compact('bendahara'));
  }

  public function edit($id)
  {
    $bendahara = Bendahara::with('user')->findOrFail($id);
    $user = User::find($bendahara->user_id);
    return view('pageadmin.master_bendahara.edit', compact('bendahara', 'user'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'nama_bendahara' => 'required',
      'nuptk' => 'required',
      'nip' => 'required',
      'username' => 'required|unique:users,username,' . $request->user_id,
      'email' => 'required|email|unique:users,email,' . $request->user_id,
    ]);

    $bendahara = Bendahara::findOrFail($id);
    
    // Update data user
    $user = User::find($bendahara->user_id);
    $user->update([
      'nama' => $request->nama_bendahara,
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
    $bendahara->update([
      'nama_bendahara' => $request->nama_bendahara,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip
    ]);

    Alert::success('Berhasil', 'Data Bendahara berhasil diperbarui');
    return redirect()->route('bendahara.index');
  }

  public function destroy($id)
  {
    $bendahara = Bendahara::findOrFail($id);
    $user = User::find($bendahara->user_id);
    
    $bendahara->delete();
    $user->delete();

    Alert::success('Berhasil', 'Data Bendahara berhasil dihapus');
    return redirect()->route('bendahara.index');
  }
}

