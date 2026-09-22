<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('SEEDER_PASSWORD');

        if (! is_string($password) || $password === '') {
            throw new RuntimeException('SEEDER_PASSWORD wajib diatur sebelum menjalankan seeder pengguna.');
        }

        DB::table('tb_user')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make($password),
                'role_id' => 1,
                'ref_id' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '19870001', // contoh NIP guru
                'password' => Hash::make($password),
                'role_id' => 2, // guru
                'ref_id' => 1,  // id guru di tb_guru (contoh)
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '99880011', // contoh NISN siswa
                'password' => Hash::make($password),
                'role_id' => 4, // siswa
                'ref_id' => 1,  // id siswa di tb_siswa (contoh)
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '19870002',
                'password' => Hash::make($password),
                'role_id' => 3, // kepala sekolah
                'ref_id' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahan Guru SD (Wali Kelas 2 - 6)
            [
                'username' => '19880001',
                'password' => Hash::make($password),
                'role_id' => 2,
                'ref_id' => 2,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '19890001',
                'password' => Hash::make($password),
                'role_id' => 2,
                'ref_id' => 3,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '19900001',
                'password' => Hash::make($password),
                'role_id' => 2,
                'ref_id' => 4,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '19910001',
                'password' => Hash::make($password),
                'role_id' => 2,
                'ref_id' => 5,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '19920001',
                'password' => Hash::make($password),
                'role_id' => 2,
                'ref_id' => 6,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahan Siswa SD (Siswa 2 - 7)
            [
                'username' => '99880012',
                'password' => Hash::make($password),
                'role_id' => 4,
                'ref_id' => 2,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '99880013',
                'password' => Hash::make($password),
                'role_id' => 4,
                'ref_id' => 3,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '99880014',
                'password' => Hash::make($password),
                'role_id' => 4,
                'ref_id' => 4,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '99880015',
                'password' => Hash::make($password),
                'role_id' => 4,
                'ref_id' => 5,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '99880016',
                'password' => Hash::make($password),
                'role_id' => 4,
                'ref_id' => 6,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '99880017',
                'password' => Hash::make($password),
                'role_id' => 4,
                'ref_id' => 7,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
