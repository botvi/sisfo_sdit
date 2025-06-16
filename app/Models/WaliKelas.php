<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;
    protected $table = 'wali_kelas';
    protected $fillable = ['user_id', 'nama_wali_kelas', 'nuptk', 'nip'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
