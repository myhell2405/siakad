<?php

namespace Tests\Feature;

use App\Models\KelasTahunAjaran;
use App\Models\Mapel;
use Database\Seeders\NilaiSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembagianKelasTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(NilaiSeeder::class);
    }

    public function test_pembagian_kelas_index_page_loads()
    {
        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->get('/admin/pembagian-kelas');

        $response->assertStatus(200);
    }

    public function test_pembagian_kelas_generate_classes()
    {
        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->post('/admin/pembagian-kelas/generate');

        $response->assertStatus(302);
    }

    public function test_kelas_ta_detail_loads()
    {
        $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->post('/admin/pembagian-kelas/generate');

        $kelasTa = KelasTahunAjaran::first();

        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->get("/admin/kelas-ta/{$kelasTa->id}/detail");

        $response->assertStatus(200);
    }

    public function test_mapel_guru_page_loads()
    {
        $mapel = Mapel::first();

        $response = $this->withSession([
            'id_user' => 1,
            'username' => 'admin',
            'role' => 'admin',
        ])->get("/admin/mapel/{$mapel->id_mapel}/guru");

        $response->assertStatus(200);
    }
}
