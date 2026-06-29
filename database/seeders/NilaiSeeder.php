<?php

namespace Database\Seeders;

use App\Models\Ekskul;
use App\Models\Guru;
use App\Models\GuruKelas;
use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\KelasTahunAjaran;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Guru SD (Wali Kelas 1 - 6)
        $dataGuru = [
            ['nip' => '19870001', 'nama' => 'Budi Santoso, S.Pd', 'jk' => 'L', 'jabatan' => 'Wali Kelas 1'],
            ['nip' => '19880001', 'nama' => 'Siti Aminah, S.Pd', 'jk' => 'P', 'jabatan' => 'Wali Kelas 2'],
            ['nip' => '19890001', 'nama' => 'Hendra Wijaya, S.Pd', 'jk' => 'L', 'jabatan' => 'Wali Kelas 3'],
            ['nip' => '19900001', 'nama' => 'Dewi Sartika, S.Pd', 'jk' => 'P', 'jabatan' => 'Wali Kelas 4'],
            ['nip' => '19910001', 'nama' => 'Agus Salim, S.Pd', 'jk' => 'L', 'jabatan' => 'Wali Kelas 5'],
            ['nip' => '19920001', 'nama' => 'Ratna Megawati, S.Pd', 'jk' => 'P', 'jabatan' => 'Wali Kelas 6'],
        ];

        $gurus = [];
        foreach ($dataGuru as $g) {
            $gurus[] = Guru::firstOrCreate(
                ['nip' => $g['nip']],
                [
                    'nama_lengkap' => $g['nama'],
                    'tempat_lahir' => 'Padang',
                    'tanggal_lahir' => '1988-05-10',
                    'jenis_kelamin' => $g['jk'],
                    'pendidikan_terakhir' => 'S1',
                    'jabatan_guru' => $g['jabatan'],
                    'alamat' => 'Jl. Pendidikan No. ' . rand(10, 99),
                    'kenagarian' => 'Nagari A',
                    'kecamatan' => 'Kecamatan B',
                    'kab_kota' => 'Kota Padang',
                    'provinsi' => 'Sumatera Barat',
                    'status' => 'Aktif',
                ]
            );
        }

        // 2. Data Siswa SD (7 Siswa contoh tersebar di kelas)
        $dataSiswa = [
            ['nisn' => '99880011', 'nama' => 'Ahmad Rizki', 'jk' => 'L', 'kelas_idx' => 0], // Kelas 1
            ['nisn' => '99880012', 'nama' => 'Siti Aisyah', 'jk' => 'P', 'kelas_idx' => 0], // Kelas 1
            ['nisn' => '99880013', 'nama' => 'Budi Darmawan', 'jk' => 'L', 'kelas_idx' => 1], // Kelas 2
            ['nisn' => '99880014', 'nama' => 'Rara Anjani', 'jk' => 'P', 'kelas_idx' => 2], // Kelas 3
            ['nisn' => '99880015', 'nama' => 'Dedi Kurniawan', 'jk' => 'L', 'kelas_idx' => 3], // Kelas 4
            ['nisn' => '99880016', 'nama' => 'Putri Lestari', 'jk' => 'P', 'kelas_idx' => 4], // Kelas 5
            ['nisn' => '99880017', 'nama' => 'Gilang Ramadhan', 'jk' => 'L', 'kelas_idx' => 5], // Kelas 6
        ];

        $siswas = [];
        foreach ($dataSiswa as $s) {
            $siswas[] = Siswa::firstOrCreate(
                ['nisn' => $s['nisn']],
                [
                    'nama_siswa' => $s['nama'],
                    'tempat_lahir' => 'Padang',
                    'tanggal_lahir' => '2015-08-15',
                    'jenis_kelamin' => $s['jk'],
                    'agama' => 'Islam',
                    'status_keluarga' => 'Anak Kandung',
                    'anak_ke' => 1,
                    'alamat_siswa' => 'Jl. Merdeka No. ' . rand(10, 99),
                ]
            );
        }

        // 3. Data Master Kelas SD (Kelas 1 sampai Kelas 6)
        $kelasNames = ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'];
        $kelasModels = [];
        foreach ($kelasNames as $idx => $nama) {
            $kelasModels[] = Kelas::firstOrCreate(
                ['nama_kelas' => $nama],
                [
                    'tingkat_kelas' => $idx + 1,
                ]
            );
        }

        // 4. Data Tahun Ajaran Aktif
        $ta = TahunAjaran::firstOrCreate(
            ['tahun_mulai' => '2025', 'tahun_selesai' => '2026', 'semester' => 'ganjil'],
            [
                'status' => 'aktif',
            ]
        );

        // 5. Pembagian Kelas Tahun Ajaran & Pendaftaran Siswa ke Kelas
        $ktaModels = [];
        foreach ($kelasModels as $idx => $k) {
            $ktaModels[] = KelasTahunAjaran::firstOrCreate(
                ['id_kelas' => $k->id_kelas, 'id_tahun_ajaran' => $ta->id_tahun_ajaran],
                [
                    'id_wali_kelas' => $gurus[$idx]->id,
                ]
            );
        }

        foreach ($dataSiswa as $idx => $s) {
            $kIdx = $s['kelas_idx'];
            SiswaKelas::firstOrCreate([
                'id_siswa' => $siswas[$idx]->id,
                'id_kelas_tahun_ajaran' => $ktaModels[$kIdx]->id,
            ]);
        }

        // 6. Data Mata Pelajaran SD & Relasi Guru Mapel
        $mapels = [
            ['nama' => 'Pendidikan Agama dan Budi Pekerti', 'kkm' => 75],
            ['nama' => 'Pendidikan Pancasila', 'kkm' => 75],
            ['nama' => 'Bahasa Indonesia', 'kkm' => 75],
            ['nama' => 'Matematika', 'kkm' => 70],
            ['nama' => 'Ilmu Pengetahuan Alam dan Sosial (IPAS)', 'kkm' => 70],
            ['nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'kkm' => 75],
            ['nama' => 'Seni dan Budaya', 'kkm' => 75],
        ];

        $mapelModels = [];
        foreach ($mapels as $mIdx => $m) {
            $mapelModel = Mapel::firstOrCreate(
                ['nama_mapel' => $m['nama']],
                ['kkm' => $m['kkm']]
            );
            $mapelModels[] = $mapelModel;

            // Assign guru mapel
            $assignedGuru = $gurus[$mIdx % count($gurus)];
            GuruMapel::firstOrCreate([
                'id_guru' => $assignedGuru->id,
                'id_mapel' => $mapelModel->id_mapel,
            ]);

            // Assign guru kelas agar mengajar lintas kelas (khusus kelas 4, 5, 6 atau seluruh kelas)
            foreach ($ktaModels as $kta) {
                GuruKelas::firstOrCreate([
                    'id_guru' => $assignedGuru->id,
                    'id_kelas_tahun_ajaran' => $kta->id,
                ]);
            }
        }

        // 7. Data Nilai Contoh
        foreach ($dataSiswa as $idx => $s) {
            $kIdx = $s['kelas_idx'];
            $siswaModel = $siswas[$idx];
            $ktaModel = $ktaModels[$kIdx];

            foreach ($mapelModels as $mapelModel) {
                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaModel->id,
                        'id_mapel' => $mapelModel->id_mapel,
                        'kelas_tahun_ajaran_id' => $ktaModel->id,
                    ],
                    [
                        'nilai_tugas' => rand(80, 95),
                        'nilai_uts' => rand(75, 90),
                        'nilai_uas' => rand(80, 95),
                        'nilai_akhir' => rand(80, 93),
                        'catatan_guru' => 'Pertahankan semangat belajarnya dan rajin berlatih.',
                        'status_validasi' => 'validated',
                    ]
                );
            }
        }

        // 8. Data Ekskul SD
        $ekskuls = [
            ['nama' => 'Pramuka SD', 'ket' => 'Kegiatan kepramukaan wajib untuk pembentukan karakter mandiri.'],
            ['nama' => 'Dokter Kecil / UKS', 'ket' => 'Pelatihan kesehatan dasar dan kebersihan lingkungan sekolah.'],
            ['nama' => 'Tari Tradisional', 'ket' => 'Melestarikan seni budaya dan tarian nusantara.'],
            ['nama' => 'Futsal SD', 'ket' => 'Pengembangan bakat olahraga sepak bola mini untuk siswa SD.'],
        ];

        foreach ($ekskuls as $idx => $e) {
            Ekskul::firstOrCreate(
                ['nama_ekskul' => $e['nama']],
                [
                    'keterangan' => $e['ket'],
                    'id_guru' => $gurus[$idx % count($gurus)]->id,
                ]
            );
        }
    }
}
