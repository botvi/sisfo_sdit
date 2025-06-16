<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTahunPelajaran extends Model
{
    use HasFactory;
    protected $table = 'master_tahun_pelajarans';
    
    protected $fillable = [
        'tahun_pelajaran',
    ];
}
