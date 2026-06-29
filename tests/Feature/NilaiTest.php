<?php

namespace Tests\Feature;

use App\Models\KelasTahunAjaran;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use Database\Seeders\NilaiSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NilaiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(NilaiSeeder::class);
    }

    public function test_admin_can_view_input_nilai_page()
    {
        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->get('/admin/nilai');

        $response->assertStatus(200);
        $response->assertSee('Kelola Nilai Siswa');
    }

    public function test_admin_can_bulk_store_nilai()
    {
        $kelasTa = KelasTahunAjaran::first();
        $mapel = Mapel::first();
        $siswa = Siswa::first();

        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->post('/admin/nilai', [
            'id_kelas_ta' => $kelasTa->id,
            'id_mapel' => $mapel->id_mapel,
            'nilais' => [
                $siswa->id => [
                    'tugas' => 80,
                    'uts' => 85,
                    'uas' => 90,
                    'catatan' => 'Sangat aktif di kelas SD.',
                ]
            ]
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Nilai Akhir harus rata-rata (80+85+90)/3 = 85
        $this->assertDatabaseHas('nilai', [
            'siswa_id' => $siswa->id,
            'id_mapel' => $mapel->id_mapel,
            'kelas_tahun_ajaran_id' => $kelasTa->id,
            'nilai_tugas' => 80,
            'nilai_uts' => 85,
            'nilai_uas' => 90,
            'nilai_akhir' => 85,
            'catatan_guru' => 'Sangat aktif di kelas SD.',
            'status_validasi' => 'submitted',
        ]);
    }

    public function test_walas_can_validate_nilai()
    {
        $nilai = Nilai::first();
        $nilai->status_validasi = 'submitted';
        $nilai->save();

        $kta = \App\Models\KelasTahunAjaran::find($nilai->kelas_tahun_ajaran_id);
        $guru = \App\Models\Guru::find($kta->id_wali_kelas);

        $response = $this->withSession([
            'id_user' => 2,
            'username' => $guru->nip,
            'role' => 'wali_kelas',
            'ref_id' => $guru->id,
            'permissions' => ['validasi_nilai'],
        ])->post('/admin/nilai/validasi/submit', [
            'id_nilai' => $nilai->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('nilai', [
            'id' => $nilai->id,
            'status_validasi' => 'validated',
        ]);
    }

    public function test_walas_can_validate_all_nilai()
    {
        Nilai::query()->update(['status_validasi' => 'submitted']);

        $guru = \App\Models\Guru::first();
        $kta = \App\Models\KelasTahunAjaran::where('id_wali_kelas', $guru->id)->first();

        $response = $this->withSession([
            'id_user' => 2,
            'username' => $guru->nip,
            'role' => 'wali_kelas',
            'ref_id' => $guru->id,
            'permissions' => ['validasi_nilai'],
        ])->post('/admin/nilai/validasi/submit', [
            'id_nilai' => 'all',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals(0, Nilai::where('kelas_tahun_ajaran_id', $kta->id)->where('status_validasi', '!=', 'validated')->count());
    }

    public function test_guru_cannot_store_nilai_for_unauthorized_mapel_or_kelas()
    {
        $guru = \App\Models\Guru::first();
        $unauthorizedMapel = \App\Models\Mapel::whereNotIn('id_mapel', function ($q) use ($guru) {
            $q->select('id_mapel')->from('guru_mapel')->where('id_guru', $guru->id);
        })->first();

        if ($unauthorizedMapel) {
            $response = $this->withSession([
                'id_user' => 3,
                'username' => $guru->nip,
                'role' => 'guru',
                'ref_id' => $guru->id,
                'permissions' => ['input_nilai_mapel'],
            ])->post('/admin/nilai', [
                'id_kelas_ta' => 1,
                'id_mapel' => $unauthorizedMapel->id_mapel,
                'nilais' => [1 => ['tugas' => 80]],
            ]);

            $response->assertStatus(403);
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_walas_can_validate_all_nilai_per_siswa()
    {
        Nilai::query()->update(['status_validasi' => 'submitted']);

        $nilai = Nilai::first();
        $kta = \App\Models\KelasTahunAjaran::find($nilai->kelas_tahun_ajaran_id);
        $guru = \App\Models\Guru::find($kta->id_wali_kelas);

        $response = $this->withSession([
            'id_user' => 2,
            'username' => $guru->nip,
            'role' => 'wali_kelas',
            'ref_id' => $guru->id,
            'permissions' => ['validasi_nilai'],
        ])->post('/admin/nilai/validasi/submit', [
            'id_nilai' => 'all_siswa',
            'siswa_id' => $nilai->siswa_id,
            'kelas_tahun_ajaran_id' => $nilai->kelas_tahun_ajaran_id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals(0, Nilai::where('siswa_id', $nilai->siswa_id)->where('kelas_tahun_ajaran_id', $nilai->kelas_tahun_ajaran_id)->where('status_validasi', '!=', 'validated')->count());
    }

    public function test_store_nilai_does_not_reset_status_validasi_if_unchanged()
    {
        $nilai = Nilai::first();
        $nilai->status_validasi = 'validated';
        $nilai->save();

        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->post('/admin/nilai', [
            'id_kelas_ta' => $nilai->kelas_tahun_ajaran_id,
            'id_mapel' => $nilai->id_mapel,
            'nilais' => [
                $nilai->siswa_id => [
                    'tugas' => $nilai->nilai_tugas,
                    'uts' => $nilai->nilai_uts,
                    'uas' => $nilai->nilai_uas,
                    'catatan' => $nilai->catatan_guru,
                ]
            ]
        ]);

        $response->assertRedirect();
        $nilai->refresh();
        $this->assertEquals('validated', $nilai->status_validasi);
    }
}
