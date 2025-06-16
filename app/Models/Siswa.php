<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswas';
    protected $fillable = ['nama_anak', 'jenis_kelamin', 'nik_anak', 'master_kelas_id', 'nis', 'nisn', 'orang_tua_wali_id'];

    public function masterKelas()
    {
        return $this->belongsTo(MasterKelas::class);
    }

    public function orangTuaWali()
    {
        return $this->belongsTo(OrangTuaWali::class);
    }
    
}
