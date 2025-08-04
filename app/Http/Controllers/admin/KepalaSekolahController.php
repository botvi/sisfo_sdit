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
    $kepalaSekolah = KepalaSekolah::getAllWithUser();
    $activeKepalaSekolah = KepalaSekolah::getActiveWithUser();
    return view('pageadmin.master_kepalasekolah.index', compact('kepalaSekolah', 'activeKepalaSekolah'));
  }

  // Method untuk mendapatkan kepala sekolah aktif
  public function getActiveKepalaSekolah()
  {
    $activeKepalaSekolah = KepalaSekolah::getActiveWithUser();
    return response()->json($activeKepalaSekolah);
  }

  // Method untuk mendapatkan statistik kepala sekolah
  public function getKepalaSekolahStats()
  {
    $stats = [
      'total' => KepalaSekolah::count(),
      'active' => KepalaSekolah::getActiveCount(),
      'inactive' => KepalaSekolah::getInactiveWithUser()->count(),
      'active_kepala_sekolah' => KepalaSekolah::getActiveWithUser(),
    ];
    
    return response()->json($stats);
  }

  // Method untuk mendapatkan kepala sekolah berdasarkan status
  public function getKepalaSekolahByStatus($status)
  {
    $kepalaSekolah = KepalaSekolah::getByStatusWithUser($status);
    return response()->json($kepalaSekolah);
  }

  // Method untuk mendapatkan kepala sekolah yang tidak aktif
  public function getInactiveKepalaSekolah()
  {
    $inactiveKepalaSekolah = KepalaSekolah::getInactiveWithUser();
    return response()->json($inactiveKepalaSekolah);
  }

  // Method untuk mendapatkan kepala sekolah yang aktif
  public function getActiveKepalaSekolahList()
  {
    $activeKepalaSekolah = KepalaSekolah::getByStatusWithUser('aktif');
    return response()->json($activeKepalaSekolah);
  }

  // Method untuk mendapatkan kepala sekolah yang tidak aktif
  public function getInactiveKepalaSekolahList()
  {
    $inactiveKepalaSekolah = KepalaSekolah::getByStatusWithUser('nonaktif');
    return response()->json($inactiveKepalaSekolah);
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
      'status' => 'required',
    ]);

    // Jika status aktif, nonaktifkan kepala sekolah lain
    if ($request->status === 'aktif') {
      KepalaSekolah::deactivateAll();
    }

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
      'nip' => $request->nip,
      'status' => $request->status
    ]);

    // Jika ini adalah kepala sekolah pertama dan status nonaktif, otomatis aktifkan
    if (KepalaSekolah::count() === 1 && $request->status === 'nonaktif') {
      KepalaSekolah::where('user_id', $user->id)->update(['status' => 'aktif']);
      Alert::success('Berhasil', 'Data Kepala Sekolah berhasil ditambahkan dan otomatis diaktifkan (karena ini adalah kepala sekolah pertama)');
    } else {
      Alert::success('Berhasil', 'Data Kepala Sekolah berhasil ditambahkan');
    }
    
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
      'status' => 'required',
    ]);

    // Validasi password jika diisi
    if ($request->filled('password')) {
      $request->validate([
        'password' => 'min:6|confirmed',
      ]);
    }

    $kepalaSekolah = KepalaSekolah::findOrFail($id);
    
    // Cek apakah kepala sekolah yang akan diubah adalah yang aktif dan status akan diubah menjadi nonaktif
    if ($kepalaSekolah->status === 'aktif' && $request->status === 'nonaktif') {
      // Cek apakah ada kepala sekolah lain yang bisa diaktifkan
      $otherKepalaSekolah = KepalaSekolah::where('id', '!=', $id)->where('status', 'nonaktif')->first();
      
      if (!$otherKepalaSekolah) {
        Alert::error('Gagal', 'Tidak dapat menonaktifkan kepala sekolah aktif. Harus ada kepala sekolah lain yang dapat diaktifkan terlebih dahulu.');
        return redirect()->route('kepala-sekolah.edit', $id);
      }
    }
    
    // Jika status diubah menjadi aktif, nonaktifkan kepala sekolah lain
    if ($request->status === 'aktif' && $kepalaSekolah->status !== 'aktif') {
      KepalaSekolah::deactivateAll();
    }
    
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

    // Update data kepala sekolah
    $kepalaSekolah->update([
      'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
      'nuptk' => $request->nuptk,
      'nip' => $request->nip,
      'status' => $request->status
    ]);

    Alert::success('Berhasil', 'Data Kepala Sekolah berhasil diperbarui');
    return redirect()->route('kepala-sekolah.index');
  }

  public function destroy($id)
  {
    $kepalaSekolah = KepalaSekolah::findOrFail($id);
    
    // Cek apakah ini adalah satu-satunya kepala sekolah
    if (KepalaSekolah::count() === 1) {
      Alert::error('Gagal', 'Tidak dapat menghapus kepala sekolah. Harus ada minimal satu kepala sekolah dalam sistem.');
      return redirect()->route('kepala-sekolah.index');
    }
    
    // Cek apakah kepala sekolah yang akan dihapus adalah yang aktif
    if ($kepalaSekolah->status === 'aktif') {
      // Cek apakah ada kepala sekolah lain yang bisa diaktifkan
      $otherKepalaSekolah = KepalaSekolah::where('id', '!=', $id)->where('status', 'nonaktif')->first();
      
      if (!$otherKepalaSekolah) {
        Alert::error('Gagal', 'Tidak dapat menghapus kepala sekolah aktif. Harus ada kepala sekolah lain yang dapat diaktifkan terlebih dahulu.');
        return redirect()->route('kepala-sekolah.index');
      }
    }
    
    $user = User::find($kepalaSekolah->user_id);
    
    $kepalaSekolah->delete();
    $user->delete();

    Alert::success('Berhasil', 'Data Kepala Sekolah berhasil dihapus');
    return redirect()->route('kepala-sekolah.index');
  }

  // Method untuk mengaktifkan kepala sekolah tertentu
  public function activate($id)
  {
    $kepalaSekolah = KepalaSekolah::findOrFail($id);
    
    // Cek apakah kepala sekolah sudah aktif
    if ($kepalaSekolah->status === 'aktif') {
      Alert::info('Info', 'Kepala Sekolah sudah aktif');
      return redirect()->route('kepala-sekolah.index');
    }
    
    // Nonaktifkan semua kepala sekolah terlebih dahulu
    KepalaSekolah::deactivateAll();
    
    // Aktifkan kepala sekolah yang dipilih
    $kepalaSekolah->update(['status' => 'aktif']);
    
    Alert::success('Berhasil', 'Kepala Sekolah berhasil diaktifkan');
    return redirect()->route('kepala-sekolah.index');
  }
}

