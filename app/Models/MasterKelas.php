<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKelas extends Model
{
    use HasFactory;
    protected $table = 'master_kelas';
    protected $fillable = ['kelas', 'wali_kelas_id'];

    public function waliKelas()
    {
        return $this->belongsTo(WaliKelas::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
    
}
