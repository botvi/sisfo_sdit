<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HafalanTahfiz extends Model
{
    use HasFactory;
    protected $table = 'hafalan_tahfizs';
    protected $fillable = ['siswa_id', 'tanggal_hafalan', 'keterangan'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}

