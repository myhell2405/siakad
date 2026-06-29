<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\TbRole;
use App\Models\TbUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AkunManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RoleSeeder::class);

        $this->admin = TbUser::create([
            'username' => 'admin_test',
            'password' => bcrypt('password'),
            'role_id'  => 1,
            'status'   => 'aktif',
        ]);
    }

    public function test_admin_can_view_akun_and_role_pages()
    {
        $response = $this->withSession([
            'id_user' => $this->admin->id_user,
            'username' => $this->admin->username,
            'role' => 'admin',
        ])->get('/admin/akun');

        $response->assertStatus(200);

        $roleResponse = $this->withSession([
            'id_user' => $this->admin->id_user,
            'username' => $this->admin->username,
            'role' => 'admin',
        ])->get('/admin/role');

        $roleResponse->assertStatus(200);
    }

    public function test_admin_can_generate_guru_accounts()
    {
        Guru::create([
            'nip' => '198001012010011001',
            'nama_lengkap' => 'Guru Test 1',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'jenis_kelamin' => 'L',
            'pendidikan_terakhir' => 'S1',
            'jabatan_guru' => 'Guru Kelas',
            'alamat' => 'Jl. Test No 1',
            'kenagarian' => 'Test',
            'kecamatan' => 'Test',
            'kab_kota' => 'Test',
            'provinsi' => 'Test',
            'status' => 'Aktif',
        ]);

        $response = $this->withSession([
            'id_user' => $this->admin->id_user,
            'username' => $this->admin->username,
            'role' => 'admin',
        ])->post('/admin/akun/generate-guru');

        $response->assertRedirect('/admin/akun');
        $this->assertDatabaseHas('tb_user', [
            'username' => '198001012010011001',
            'role_id' => 2,
        ]);
    }

    public function test_admin_can_generate_siswa_accounts()
    {
        Siswa::create([
            'nisn' => '0123456789',
            'nama_siswa' => 'Siswa Test 1',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2015-01-01',
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
        ]);

        $response = $this->withSession([
            'id_user' => $this->admin->id_user,
            'username' => $this->admin->username,
            'role' => 'admin',
        ])->post('/admin/akun/generate-siswa');

        $response->assertRedirect('/admin/akun');
        $this->assertDatabaseHas('tb_user', [
            'username' => '0123456789',
            'role_id' => 4,
        ]);
    }

    public function test_admin_can_reset_password()
    {
        $user = TbUser::create([
            'username' => 'user_test',
            'password' => bcrypt('oldpassword'),
            'role_id' => 4,
            'status' => 'aktif',
        ]);

        $response = $this->withSession([
            'id_user' => $this->admin->id_user,
            'username' => $this->admin->username,
            'role' => 'admin',
        ])->patch("/admin/akun/{$user->id_user}/reset-password");

        $response->assertRedirect();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('1234', $user->fresh()->password));
    }

    public function test_admin_can_update_role_permissions()
    {
        $role = TbRole::find(4); // role siswa

        $response = $this->withSession([
            'id_user' => $this->admin->id_user,
            'username' => $this->admin->username,
            'role' => 'admin',
        ])->put("/admin/role/{$role->id_role}", [
            'permissions' => ['portal_siswa', 'view_nilai_siswa', 'input_nilai_mapel'],
        ]);

        $response->assertRedirect('/admin/role');
        $this->assertEquals(['portal_siswa', 'view_nilai_siswa', 'input_nilai_mapel'], $role->fresh()->permissions);
    }
}
