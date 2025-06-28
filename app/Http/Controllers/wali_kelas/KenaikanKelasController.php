<?php

namespace App\Http\Controllers\wali_kelas;

use App\Http\Controllers\Controller;
use App\Models\MasterKelas;
use App\Models\Siswa;
use App\Models\OrangTuaWali;
use Illuminate\Http\Request;

class KenaikanKelasController extends Controller
{
   

    public function pindahKelasMultiple(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:siswas,id',
            'master_kelas_id' => 'required|exists:master_kelas,id'
        ]);

        try {
            $siswaIds = $request->siswa_ids;
            $masterKelasId = $request->master_kelas_id;

            // Update master_kelas_id untuk semua siswa yang dipilih
            Siswa::whereIn('id', $siswaIds)->update([
                'master_kelas_id' => $masterKelasId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memindahkan ' . count($siswaIds) . ' siswa ke kelas baru'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memindahkan siswa: ' . $e->getMessage()
            ], 500);
        }
    }
    
}