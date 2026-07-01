<?php

namespace Tests\Feature;

use Database\Seeders\NilaiSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(NilaiSeeder::class);
    }

    public function test_walas_routes()
    {
        $response = $this->withSession([
            'id_user' => 2,
            'username' => '19870001',
            'role' => 'wali_kelas',
            'ref_id' => 1,
            'permissions' => ['input_nilai_mapel', 'validasi_nilai', 'laporan_akademik'],
        ])->get('/admin/dashboard');

        $response->assertStatus(200);

        $this->withSession(['id_user' => 2, 'role' => 'wali_kelas', 'ref_id' => 1, 'permissions' => ['validasi_nilai']])
            ->get('/admin/nilai/validasi')->assertStatus(200);
        $this->withSession(['id_user' => 2, 'role' => 'wali_kelas', 'ref_id' => 1, 'permissions' => ['laporan_akademik']])
            ->get('/admin/laporan/rapor')->assertStatus(200);
        $this->withSession(['id_user' => 2, 'role' => 'wali_kelas', 'ref_id' => 1])
            ->get('/admin/profil')->assertStatus(200);
    }

    public function test_kepsek_routes()
    {
        $response = $this->withSession([
            'id_user' => 4,
            'username' => '19870002',
            'role' => 'kepala_sekolah',
            'ref_id' => null,
            'permissions' => ['monitoring_akademik'],
        ])->get('/admin/dashboard');

        $response->assertStatus(200);

        $this->withSession(['id_user' => 4, 'role' => 'kepala_sekolah', 'permissions' => ['monitoring_akademik']])
            ->get('/admin/laporan/monitoring')->assertStatus(200);
        $this->withSession(['id_user' => 4, 'role' => 'kepala_sekolah', 'permissions' => ['monitoring_akademik']])
            ->get('/admin/laporan/identitas-siswa')->assertStatus(200);
        $this->withSession(['id_user' => 4, 'role' => 'kepala_sekolah', 'permissions' => ['monitoring_akademik']])
            ->get('/admin/laporan/rapor')->assertStatus(200);
    }

    public function test_siswa_routes()
    {
        $response = $this->withSession([
            'id_user' => 3,
            'username' => '99880011',
            'role' => 'siswa',
            'ref_id' => 1,
            'permissions' => ['view_nilai_siswa'],
        ])->get('/admin/dashboard');

        $response->assertStatus(200);

        $this->withSession(['id_user' => 3, 'role' => 'siswa', 'ref_id' => 1, 'permissions' => ['view_nilai_siswa']])
            ->get('/admin/laporan/rapor')->assertStatus(200)->assertDontSee('Isi Data');
        $this->withSession(['id_user' => 3, 'role' => 'siswa', 'ref_id' => 1, 'permissions' => ['view_nilai_siswa']])
            ->get('/admin/nilai')->assertStatus(200)->assertSee('Transkrip Nilai Akademik');
        $this->withSession(['id_user' => 3, 'role' => 'siswa'])
            ->get('/admin/profil')->assertStatus(200);

        // Siswa dilarang menyimpan atau mengubah nilai & rapor
        $this->withSession(['id_user' => 3, 'role' => 'siswa'])->post('/admin/nilai', [])->assertStatus(403);
        $this->withSession(['id_user' => 3, 'role' => 'siswa'])->post('/admin/laporan/rapor/simpan', [])->assertStatus(403);
    }
}
