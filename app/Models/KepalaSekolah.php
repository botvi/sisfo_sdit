<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    use HasFactory;
    protected $table = 'kepala_sekolah';
    protected $fillable = ['user_id', 'nama_kepala_sekolah', 'nuptk', 'nip'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
