<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    LoginController,
    ProfilController,
};

use App\Http\Controllers\admin\{
    DashboardAdminController,
    BendaharaController,
    MasterKelasController,
    MasterTahunPelajaranController,
    PengumumanController,
    WaliKelasController,
    WhatsappApiController,
    KepalaSekolahController,
};

use App\Http\Controllers\bendahara\{
    DashboardBendaharaController,
    SppSiswaController,
};

use App\Http\Controllers\wali_kelas\{
    DashboardWaliKelasController,
    HafalanTahfizController,
    OrangTuaWalidanSiswaController,
    SiswaController,
    KenaikanKelasController,
};

use App\Http\Controllers\kepala_sekolah\{
    DashboardKepalaSekolahController,
};

use App\Http\Controllers\laporan\{
    LaporanController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/run-admin', function () {
    Artisan::call('db:seed', [
        '--class' => 'SuperAdminSeeder'
    ]);

    return "AdminSeeder has been create successfully!";
});
Route::get('/', [LoginController::class, 'showLoginForm'])->name('formlogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');


Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->name('dashboard-admin');
    Route::resource('bendahara', BendaharaController::class);
    Route::resource('master-kelas', MasterKelasController::class);
    Route::resource('master-tahun-pelajaran', MasterTahunPelajaranController::class);
    Route::resource('pengumuman', PengumumanController::class);

    Route::get('pengumuman/share-facebook/{nama_pengumuman}', [PengumumanController::class, 'shareurltofacebook'])->name('pengumuman.shareurltofacebook');
    Route::get('pengumuman/show/{nama_pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');

    Route::resource('wali-kelas', WaliKelasController::class);
    Route::resource('kepala-sekolah', KepalaSekolahController::class);
    Route::get('whatsapp-api', [WhatsappApiController::class, 'index'])->name('whatsapp-api.index');
    Route::post('whatsapp-api', [WhatsappApiController::class, 'storeorupdate'])->name('whatsapp-api.storeorupdate');
});

Route::group(['middleware' => ['role:bendahara']], function () {
    Route::get('/dashboard-bendahara', [DashboardBendaharaController::class, 'index'])->name('dashboard-bendahara');
    Route::resource('spp', SppSiswaController::class);

    Route::get('spp/kartu-pembayaran/{nama_anak}', [SppSiswaController::class, 'kartuSpp'])->name('spp.kartu-pembayaran');
    Route::get('spp/filter', [SppSiswaController::class, 'showpagefilter'])->name('spp.showpagefilter');
    Route::post('spp/filter', [SppSiswaController::class, 'filter'])->name('spp.filter');
    Route::post('spp/kirim-pesan-belum-bayar', [SppSiswaController::class, 'kirimPesanBelumBayar'])->name('spp.kirim-pesan-belum-bayar');
});

Route::group(['middleware' => ['role:wali_kelas']], function () {
    Route::get('/dashboard-wali-kelas', [DashboardWaliKelasController::class, 'index'])->name('dashboard-wali-kelas');
    Route::resource('hafalan-tahfiz', HafalanTahfizController::class);
    Route::resource('orang-tua-wali-dan-siswa', OrangTuaWalidanSiswaController::class);
    Route::post('/pindah-kelas-multiple', [KenaikanKelasController::class, 'pindahKelasMultiple'])->name('pindah-kelas-multiple');
});

Route::group(['middleware' => ['role:kepala_sekolah']], function () {
    Route::get('/dashboard-kepala-sekolah', [DashboardKepalaSekolahController::class, 'index'])->name('dashboard-kepala-sekolah');
});

Route::group(['middleware' => ['role:admin,kepala_sekolah']], function () {
    Route::get('/laporan/pembayaran-spp', [LaporanController::class, 'laporanpembayaranspp'])->name('laporan.pembayaran.spp');
    Route::get('/laporan/pembayaran-spp/print', [LaporanController::class, 'printLaporanPembayaranSpp'])->name('laporan.pembayaran.spp.print');

    Route::get('/laporan/data-orang-tua-dan-siswa', [LaporanController::class, 'laporandataorangtuadansiswa'])->name('laporan.data.orang.tua.dan.siswa');
    Route::get('/laporan/data-orang-tua-dan-siswa/print', [LaporanController::class, 'printLaporanDataOrangTuaDanSiswa'])->name('laporan.data.orang.tua.dan.siswa.print');
});
