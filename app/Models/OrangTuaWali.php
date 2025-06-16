<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTuaWali extends Model
{
    use HasFactory;
    protected $table = 'orang_tua_walis';
    protected $fillable = ['nama_ibu', 'nik_ibu', 'nama_ayah', 'nik_ayah', 'alamat_ortu', 'no_wa_ortu', 'nama_wali', 'nik_wali', 'alamat_wali', 'no_wa_wali'];
}
