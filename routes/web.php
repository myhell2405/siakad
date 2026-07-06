<?php

use App\Http\Controllers\Admin\EkskulController;
use App\Http\Controllers\Admin\GuruAdminController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KelasTahunAjaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\MapelGuruController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\PembagianKelasController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiswaAdminController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\WaliSiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN PORTAL (UNIFIED FOR ALL ROLES)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth.session'])
    ->group(function () {

        // Terbuka untuk semua role yang sudah login
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard-statis', function () {
            return view('admin.dashboard_statis');
        })->name('dashboard.statis');
        Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
        Route::put('/profil/password', [AdminController::class, 'updatePassword'])->name('profil.password');
        Route::post('/unimpersonate', [AkunController::class, 'unimpersonate'])->name('unimpersonate');

        // Master Data (Khusus Admin / kelola_master)
        Route::middleware(['role:admin,kelola_master'])->group(function () {
            Route::resource('guru', GuruAdminController::class);
            Route::get('siswa/export', [SiswaAdminController::class, 'export'])->name('siswa.export');
            Route::get('siswa/{id}/transkrip', [SiswaAdminController::class, 'transkrip'])->name('siswa.transkrip');
            Route::resource('siswa', SiswaAdminController::class);
            Route::resource('kelas', KelasController::class);
            Route::resource('mapel', MapelController::class);
            Route::resource('ekskul', EkskulController::class);
            Route::resource('wali-siswa', WaliSiswaController::class);
            Route::resource('tahun-ajaran', TahunAjaranController::class);

            Route::get('/wali-siswa/cari-siswa/{nisn}', [WaliSiswaController::class, 'cariSiswa'])
                ->name('wali-siswa.cari-siswa');

            Route::prefix('mapel/{id_mapel}/guru')
                ->name('mapel.guru.')
                ->group(function () {
                    Route::get('/', [MapelGuruController::class, 'index'])->name('index');
                    Route::post('/', [MapelGuruController::class, 'store'])->name('store');
                    Route::delete('/{id_guru}', [MapelGuruController::class, 'destroy'])->name('destroy');
                });

            Route::prefix('kelas/{id}/guru')
                ->name('kelas.guru.')
                ->group(function () {
                    Route::get('/', [KelasController::class, 'guruIndex'])->name('index');
                    Route::post('/', [KelasController::class, 'guruStore'])->name('store');
                    Route::delete('/', [KelasController::class, 'guruDestroy'])->name('destroy');
                });
        });

        // Pembagian Kelas
        Route::middleware(['role:admin,pembagian_kelas'])->group(function () {
            Route::prefix('pembagian-kelas')
                ->name('pembagian-kelas.')
                ->group(function () {
                    Route::get('/', [PembagianKelasController::class, 'index'])->name('index');
                    Route::post('/generate', [PembagianKelasController::class, 'generate'])->name('generate');
                    Route::patch('/{id}/wali-kelas', [PembagianKelasController::class, 'updateWaliKelas'])->name('update-wali-kelas');
                });

            Route::prefix('kelas-ta')
                ->name('kelas-ta.')
                ->group(function () {
                    Route::post('/{id_kelas}/store', [KelasTahunAjaranController::class, 'store'])->name('store');
                    Route::get('/{id}/detail', [KelasTahunAjaranController::class, 'detail'])->name('detail');
                    Route::delete('/{id}', [KelasTahunAjaranController::class, 'destroy'])->name('destroy');

                    Route::post('/{id}/siswa', [KelasTahunAjaranController::class, 'storeSiswa'])->name('siswa.store');
                    Route::delete('/siswa/{id}', [KelasTahunAjaranController::class, 'destroySiswa'])->name('siswa.destroy');

                    Route::post('/{id}/guru', [KelasTahunAjaranController::class, 'storeGuru'])->name('guru.store');
                    Route::delete('/guru/{id}', [KelasTahunAjaranController::class, 'destroyGuru'])->name('guru.destroy');
                });
        });

        // Kelola Nilai / Transkrip Nilai (Admin, Guru, Wali Kelas, Siswa)
        Route::middleware(['role:admin,guru,wali_kelas,siswa,kelola_nilai_admin,input_nilai_mapel,view_nilai_siswa'])->group(function () {
            Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        });

        Route::middleware(['role:admin,guru,wali_kelas,kelola_nilai_admin,input_nilai_mapel'])->group(function () {
            Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
        });

        // Validasi Nilai (Admin, Wali Kelas)
        Route::middleware(['role:admin,wali_kelas,validasi_nilai'])->group(function () {
            Route::get('/nilai/validasi', [NilaiController::class, 'validasi'])->name('nilai.validasi');
            Route::post('/nilai/validasi/submit', [NilaiController::class, 'submitValidasi'])->name('nilai.validasi.submit');
        });

        // Laporan & Rapor
        Route::middleware(['role:admin,wali_kelas,kepala_sekolah,siswa,laporan_akademik,monitoring_akademik,view_nilai_siswa'])->group(function () {
            Route::prefix('laporan')
                ->name('laporan.')
                ->group(function () {
                    Route::get('/identitas-siswa', [LaporanController::class, 'identitasSiswa'])->name('identitas-siswa');
                    Route::get('/identitas-guru', [LaporanController::class, 'identitasGuru'])->name('identitas-guru');
                    Route::get('/rapor', [LaporanController::class, 'rapor'])->name('rapor');
                    Route::post('/rapor/simpan', [LaporanController::class, 'simpanRapor'])->name('rapor.simpan');
                    Route::get('/monitoring', [LaporanController::class, 'monitoring'])->name('monitoring');
                    Route::get('/transkrip', [LaporanController::class, 'transkrip'])->name('transkrip');
                });
        });

        // Manajemen Akun
        Route::middleware(['role:admin,kelola_akun'])->group(function () {
            Route::post('/akun/generate-guru', [AkunController::class, 'generateGuru'])->name('akun.generate-guru');
            Route::post('/akun/generate-siswa', [AkunController::class, 'generateSiswa'])->name('akun.generate-siswa');
            Route::post('/akun/{id}/impersonate', [AkunController::class, 'impersonate'])->name('akun.impersonate');
            Route::patch('/akun/{id}/reset-password', [AkunController::class, 'resetPassword'])->name('akun.reset-password');
            Route::resource('akun', AkunController::class)->except(['create', 'edit', 'show']);

            Route::get('/role', [RoleController::class, 'index'])->name('role.index');
            Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
        });
    });
