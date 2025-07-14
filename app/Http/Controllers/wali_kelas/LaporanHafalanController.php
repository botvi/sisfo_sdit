<?php

namespace App\Http\Controllers\wali_kelas;

use App\Http\Controllers\Controller;
use App\Models\HafalanTahfiz;
use App\Models\WaliKelas;
use App\Models\MasterKelas;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class LaporanHafalanController extends Controller
{
    public function index()
    {
         // Mendapatkan wali kelas berdasarkan user yang login
        // Mendapatkan data wali kelas yang sedang login
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        
        // Mendapatkan data hafalan untuk siswa di kelas yang diampu
        $data = HafalanTahfiz::with(['siswa.masterKelas'])
            ->whereHas('siswa.masterKelas', function ($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            })
            ->get();
            
        return view('pagewalikelas.laporan_hafalan.index', compact('data', 'waliKelas'));
    }

    public function printLaporanHafalan(Request $request)
    {
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        $data = HafalanTahfiz::with(['siswa.masterKelas'])
            ->whereHas('siswa.masterKelas', function ($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            })
            ->get();
        return view('pagewalikelas.laporan_hafalan.print', compact('data', 'waliKelas'));
    }
}