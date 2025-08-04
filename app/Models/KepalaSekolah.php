<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    use HasFactory;
    protected $table = 'kepala_sekolah';
    protected $fillable = ['user_id', 'nama_kepala_sekolah', 'nuptk', 'nip', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk mendapatkan kepala sekolah yang aktif
    public static function getActive()
    {
        return self::where('status', 'aktif')->first();
    }

    // Method untuk mendapatkan kepala sekolah aktif dengan relasi user
    public static function getActiveWithUser()
    {
        return self::with('user')->where('status', 'aktif')->first();
    }

    // Method untuk mendapatkan semua kepala sekolah dengan relasi user
    public static function getAllWithUser()
    {
        return self::with('user')->get();
    }

    // Method untuk mengecek apakah ada kepala sekolah aktif
    public static function hasActive()
    {
        return self::where('status', 'aktif')->exists();
    }

    // Method untuk mendapatkan jumlah kepala sekolah aktif
    public static function getActiveCount()
    {
        return self::where('status', 'aktif')->count();
    }

    // Method untuk mendapatkan kepala sekolah yang tidak aktif
    public static function getInactive()
    {
        return self::where('status', 'nonaktif')->get();
    }

    // Method untuk mendapatkan kepala sekolah yang tidak aktif dengan relasi user
    public static function getInactiveWithUser()
    {
        return self::with('user')->where('status', 'nonaktif')->get();
    }

    // Method untuk mendapatkan kepala sekolah berdasarkan status
    public static function getByStatus($status)
    {
        return self::where('status', $status)->get();
    }

    // Method untuk mendapatkan kepala sekolah berdasarkan status dengan relasi user
    public static function getByStatusWithUser($status)
    {
        return self::with('user')->where('status', $status)->get();
    }

    // Method untuk mengecek apakah kepala sekolah tertentu aktif
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    // Method untuk mengecek apakah sistem memiliki kepala sekolah aktif
    public static function hasActiveKepalaSekolah()
    {
        return self::where('status', 'aktif')->exists();
    }

    // Method untuk menonaktifkan semua kepala sekolah
    public static function deactivateAll()
    {
        return self::where('status', 'aktif')->update(['status' => 'nonaktif']);
    }
}
