<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppSiswa extends Model
{
    use HasFactory;
    protected $table = 'spp_siswas';
    protected $fillable = ['siswa_id', 'tanggal_bayar', 'bulan_bayar', 'jumlah_bayar', 'tahun_pelajaran_id', 'status_bayar'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(MasterTahunPelajaran::class, 'tahun_pelajaran_id');
    }
}
