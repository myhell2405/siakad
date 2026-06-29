<?php

namespace Tests\Feature;

use App\Models\KelasTahunAjaran;
use App\Models\Rapor;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use Database\Seeders\NilaiSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(NilaiSeeder::class);
    }

    public function test_laporan_pages_load_successfully()
    {
        $session = [
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ];

        // 1. Identitas Siswa
        $this->withSession($session)->get('/admin/laporan/identitas-siswa')->assertStatus(200);

        // 2. Identitas Guru
        $this->withSession($session)->get('/admin/laporan/identitas-guru')->assertStatus(200);

        // 3. Rapor Siswa
        $this->withSession($session)->get('/admin/laporan/rapor')->assertStatus(200);

        // 4. Monitoring Akademik
        $this->withSession($session)->get('/admin/laporan/monitoring')->assertStatus(200);
    }

    public function test_simpan_rapor_pelengkap()
    {
        $session = [
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ];

        $siswa = Siswa::first();
        $kta = KelasTahunAjaran::first();
        $siswaKelas = SiswaKelas::firstOrCreate([
            'id_siswa' => $siswa->id,
            'id_kelas_tahun_ajaran' => $kta->id,
        ]);
        $this->assertNotNull($siswaKelas);

        $ekskul = \App\Models\Ekskul::create(['nama_ekskul' => 'Pramuka']);

        $response = $this->withSession($session)->post('/admin/laporan/rapor/simpan', [
            'siswa_id' => $siswaKelas->id_siswa,
            'kelas_tahun_ajaran_id' => $siswaKelas->id_kelas_tahun_ajaran,
            'sakit' => 2,
            'izin' => 1,
            'alpa' => 0,
            'catatan_wali_kelas' => 'Sangat baik, pertahankan prestasimu.',
            'status_kenaikan' => 'Naik Kelas',
            'has_ekskul_form' => 1,
            'ekskul' => [
                $ekskul->id_ekskul => [
                    'selected' => 1,
                    'predikat' => 'Sangat Baik',
                    'keterangan' => 'Aktif sebagai pimpinan regu pramuka',
                ]
            ]
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rapor', [
            'siswa_id' => $siswaKelas->id_siswa,
            'kelas_tahun_ajaran_id' => $siswaKelas->id_kelas_tahun_ajaran,
            'sakit' => 2,
            'izin' => 1,
            'catatan_wali_kelas' => 'Sangat baik, pertahankan prestasimu.',
            'status_kenaikan' => 'Naik Kelas',
        ]);

        $this->assertDatabaseHas('nilai_ekskul', [
            'siswa_id' => $siswaKelas->id_siswa,
            'kelas_tahun_ajaran_id' => $siswaKelas->id_kelas_tahun_ajaran,
            'id_ekskul' => $ekskul->id_ekskul,
            'predikat' => 'Sangat Baik',
            'keterangan' => 'Aktif sebagai pimpinan regu pramuka',
        ]);
    }
}
