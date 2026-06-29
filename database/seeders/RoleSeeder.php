<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id_role' => 1, 
                'nama_role' => 'admin', 
                'deskripsi' => 'Administrator sistem',
                'permissions' => ['kelola_master', 'kelola_akun', 'pembagian_kelas', 'kelola_nilai_admin', 'laporan_akademik']
            ],
            [
                'id_role' => 2, 
                'nama_role' => 'guru', 
                'deskripsi' => 'Guru mata pelajaran',
                'permissions' => ['portal_guru', 'input_nilai_mapel']
            ],
            [
                'id_role' => 3, 
                'nama_role' => 'kepala_sekolah', 
                'deskripsi' => 'Kepala sekolah',
                'permissions' => ['portal_kepsek', 'monitoring_akademik', 'view_laporan']
            ],
            [
                'id_role' => 4, 
                'nama_role' => 'siswa', 
                'deskripsi' => 'Peserta didik / Orang tua',
                'permissions' => ['portal_siswa', 'view_nilai_siswa', 'cetak_rapor_siswa']
            ],
            [
                'id_role' => 5, 
                'nama_role' => 'wali_kelas', 
                'deskripsi' => 'Wali Kelas',
                'permissions' => ['portal_guru', 'input_nilai_mapel', 'validasi_nilai', 'cetak_rapor_kelas']
            ],
        ];

        foreach ($roles as $role) {
            DB::table('tb_role')->updateOrInsert(
                ['id_role' => $role['id_role']],
                [
                    'nama_role' => $role['nama_role'],
                    'deskripsi' => $role['deskripsi'],
                    'permissions' => json_encode($role['permissions']),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
