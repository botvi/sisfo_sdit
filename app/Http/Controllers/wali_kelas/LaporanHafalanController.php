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
    public function index(Request $request)
    {
         // Mendapatkan wali kelas berdasarkan user yang login
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        
        // Mendapatkan data hafalan untuk siswa di kelas yang diampu
        $query = HafalanTahfiz::with(['siswa.masterKelas'])
            ->whereHas('siswa.masterKelas', function ($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            });

        // Pencarian berdasarkan nama siswa atau keterangan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($subQuery) use ($search) {
                    $subQuery->where('nama_anak', 'like', '%' . $search . '%');
                })->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        $data = $query->get();
        $groupedData = $data->groupBy('siswa_id');
        
        return view('pagewalikelas.laporan_hafalan.index', compact('data', 'waliKelas', 'groupedData'));
    }

    public function printLaporanHafalan(Request $request)
    {
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        
        $query = HafalanTahfiz::with(['siswa.masterKelas'])
            ->whereHas('siswa.masterKelas', function ($query) use ($waliKelas) {
                $query->where('wali_kelas_id', $waliKelas->id);
            });

        // Pencarian berdasarkan nama siswa atau keterangan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($subQuery) use ($search) {
                    $subQuery->where('nama_anak', 'like', '%' . $search . '%');
                })->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        $data = $query->get();
        
        // Mengelompokkan data berdasarkan siswa
        $groupedData = $data->groupBy('siswa_id');
        
        return view('pagewalikelas.laporan_hafalan.print', compact('groupedData', 'waliKelas'));
    }

    public function printPerSiswa(Request $request, $siswaId)
    {
        $waliKelas = WaliKelas::where('user_id', Auth::id())->first();
        
        // Mendapatkan data siswa
        $siswa = \App\Models\Siswa::with('masterKelas')->findOrFail($siswaId);
        
        // Memastikan siswa berada di kelas yang diampu wali kelas
        if ($siswa->masterKelas->wali_kelas_id != $waliKelas->id) {
            abort(403, 'Unauthorized');
        }
        
        // Mendapatkan semua data hafalan siswa
        $hafalanData = HafalanTahfiz::where('siswa_id', $siswaId)
            ->orderBy('tanggal_hafalan', 'asc')
            ->get();
        
        return view('pagewalikelas.laporan_hafalan.print_per_siswa', compact('siswa', 'hafalanData', 'waliKelas'));
    }
}