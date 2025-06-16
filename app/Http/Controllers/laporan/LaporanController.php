<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use App\Models\SppSiswa;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Models\Bendahara;
use App\Models\MasterKelas;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanpembayaranspp(Request $request)
    {
        $kelas = MasterKelas::with('waliKelas')->get();
        $bendahara = User::where('role', 'bendahara')->first();

        $query = SppSiswa::with(['siswa.masterKelas.waliKelas', 'tahunPelajaran']);

        if ($request->has('master_kelas_id') && $request->master_kelas_id != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('master_kelas_id', $request->master_kelas_id);
            });
        }

        $sppSiswa = $query->orderBy('tanggal_bayar', 'desc')->get();

        return view('pagelaporan.laporanpembayaranspp.index', compact('sppSiswa', 'kelas', 'bendahara'));
    }

    public function printLaporanPembayaranSpp(Request $request)
    {
        $kelas = MasterKelas::with('waliKelas')->get();
        $bendahara = User::where('role', 'bendahara')->first();
        $query = SppSiswa::with(['siswa.masterKelas.waliKelas', 'tahunPelajaran']);

        if ($request->has('master_kelas_id') && $request->master_kelas_id != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('master_kelas_id', $request->master_kelas_id);
            });
        }

        $sppSiswa = $query->orderBy('tanggal_bayar', 'desc')->get();

        return view('pagelaporan.laporanpembayaranspp.print', compact('sppSiswa', 'kelas', 'bendahara'));
    }

    public function laporandataorangtuadansiswa(Request $request)
    {
        $kelas = MasterKelas::with('waliKelas')->get();

        $query = Siswa::with(['masterKelas.waliKelas', 'orangTuaWali']);

        if ($request->has('master_kelas_id') && $request->master_kelas_id != '') {
            $query->where('master_kelas_id', $request->master_kelas_id);
        }

        $siswa = $query->get();

        return view('pagelaporan.laporandataorangtuadansiswa.index', compact('siswa', 'kelas'));
    }

    public function printLaporanDataOrangTuaDanSiswa(Request $request)
    {
        $kelas = MasterKelas::with('waliKelas')->get();
        $query = Siswa::with(['masterKelas.waliKelas', 'orangTuaWali']);

        if ($request->has('master_kelas_id') && $request->master_kelas_id != '') {
            $query->where('master_kelas_id', $request->master_kelas_id);
        }

        $siswa = $query->get();

        return view('pagelaporan.laporandataorangtuadansiswa.print', compact('siswa', 'kelas'));
    }
}
