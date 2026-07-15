<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\WaliSiswa;
use App\Models\Ekskul;
use App\Models\Mapel;

class DataSekolahSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Mapel (Mata Pelajaran Dasar SD dari Rapor)
        $mapels = [
            'Pendidikan Agama Islam dan Budi Pekerti',
            'Pendidikan Pancasila dan Kewarganegaraan',
            'Bahasa Indonesia',
            'Matematika',
            'Pendidikan Jasmani Olahraga dan Kesehatan',
            'Seni Rupa',
            'Bahasa Inggris',
            'Muatan Lokal',
        ];

        foreach ($mapels as $mapel) {
            Mapel::firstOrCreate(['nama_mapel' => $mapel], ['kkm' => 75]);
        }

        // 2. Data Guru (Dari Tabel Pembagian Tugas Mengajar)
        $gurus = [
            [
                'nip' => '198410272011012004',
                'nama_lengkap' => 'Alia Oktavia, S.Pd. SD',
                'jabatan_guru' => 'Kepala Sekolah',
                'pangkat_gol' => 'III/b',
            ],
            [
                'nip' => '197001232008012003',
                'nama_lengkap' => 'Sumarni, S.Pd. SD',
                'jabatan_guru' => 'Guru Kelas',
                'pangkat_gol' => 'III/c',
            ],
            [
                'nip' => '197408092014082001',
                'nama_lengkap' => 'Laila Sofia, S. Ag',
                'jabatan_guru' => 'Guru Mapel (PAIdBP)',
                'pangkat_gol' => 'III/b',
            ],
            [
                'nip' => '198402042022212010',
                'nama_lengkap' => 'Kuntum Chaira Yori, S.Pd',
                'tempat_lahir' => 'DURIAN GADANG',
                'tanggal_lahir' => '1984-02-04',
                'pendidikan_terakhir' => 'S1. PGSD',
                'jabatan_guru' => 'Guru Kelas',
                'pangkat_gol' => 'Ahli Pertama, IX',
            ],
            [
                'nip' => '199610142022211001',
                'nama_lengkap' => 'Ahmad Faizal, S.Pd',
                'jabatan_guru' => 'Guru Mapel (Olahraga)',
                'pangkat_gol' => 'Ahli Pertama, IX',
            ],
            [
                'nip' => '198011272023212008',
                'nama_lengkap' => 'Lusi Novica, S.Pd.SD',
                'jabatan_guru' => 'Guru Kelas',
                'pangkat_gol' => 'Ahli Pertama, IX',
            ],
            [
                'nip' => '198812042023212015',
                'nama_lengkap' => 'Esna Yola, S.Pd',
                'jabatan_guru' => 'Guru Kelas',
                'pangkat_gol' => 'Ahli Pertama, IX',
            ],
            [
                'nip' => '199112022025212015',
                'nama_lengkap' => 'Meri Desmita, S.Pd',
                'jabatan_guru' => 'Guru Kelas',
                'pangkat_gol' => 'Ahli Pertama, IX',
            ],
            [
                'nip' => '199703062025212015',
                'nama_lengkap' => 'Aisyah Aminul Haqi, S.Pd',
                'jabatan_guru' => 'Guru Kelas',
                'pangkat_gol' => 'Ahli Pertama, IX',
            ],
            [
                'nip' => 'HONOR01',
                'nama_lengkap' => 'Salshabila, S.Pd',
                'jabatan_guru' => 'Guru Mapel Honor',
                'pangkat_gol' => '-',
            ],
            [
                'nip' => 'HONOR02',
                'nama_lengkap' => 'Dewi Ningsih',
                'jabatan_guru' => 'Jaga Sekolah',
                'pangkat_gol' => '-',
            ]
        ];

        $defaultGuru = [
            'tempat_lahir' => '-',
            'tanggal_lahir' => '1980-01-01',
            'jenis_kelamin' => 'P',
            'pendidikan_terakhir' => 'S1',
            'alamat' => '-',
            'kenagarian' => '-',
            'kecamatan' => '-',
            'kab_kota' => '-',
            'provinsi' => '-',
            'no_telepon' => '-',
            'email' => '-',
        ];

        foreach ($gurus as $guruData) {
            $guruData['nuptk'] = $guruData['nuptk'] ?? ('-' . $guruData['nip']);
            Guru::updateOrCreate(
                ['nip' => $guruData['nip']],
                array_merge($defaultGuru, $guruData, ['status' => 'aktif'])
            );
        }

        // 3. Data Ekskul Sekolah Dasar
        $ekskuls = [
            ['nama' => 'Pramuka', 'ket' => 'Ekstrakurikuler Wajib'],
            ['nama' => 'UKS / Dokter Kecil', 'ket' => 'Usaha Kesehatan Sekolah'],
            ['nama' => 'Olahraga', 'ket' => 'Sepak Bola & Bulutangkis'],
            ['nama' => 'Kesenian', 'ket' => 'Seni Tari Tradisional & Drumband'],
            ['nama' => 'Rohis', 'ket' => 'Baca Tulis Al-Quran (BTA)'],
        ];

        $pembina = Guru::where('jabatan_guru', 'like', '%Olahraga%')->first();

        foreach ($ekskuls as $ek) {
            Ekskul::firstOrCreate(
                ['nama_ekskul' => $ek['nama']],
                ['keterangan' => $ek['ket'], 'id_guru' => $pembina ? $pembina->id : null]
            );
        }

        // 4. Data Siswa dan Wali Siswa Kelas 1
        $siswas = [
            [
                'nisn' => '3187382144',
                'nama_siswa' => 'FIONA PUTRI SETIAWAN',
                'tempat_lahir' => 'Pekanbaru',
                'tanggal_lahir' => '2018-01-12',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'status_keluarga' => 'Anak Kandung',
                'anak_ke' => 1,
                'alamat_siswa' => 'Durian Gadang',
                'sekolah_asal' => 'TK Syuhada',
                'tanggal_diterima' => '2024-07-15',
                'wali' => [
                    ['nama_wali' => 'ARY SETIAWAN', 'hubungan' => 'Ayah', 'pekerjaan' => 'Petani', 'telepon' => '085265275924', 'alamat' => 'Durian Gadang'],
                    ['nama_wali' => 'DIAN PERMATA PUTRI', 'hubungan' => 'Ibu', 'pekerjaan' => 'Rumah Tangga', 'telepon' => '085265275924', 'alamat' => 'Durian Gadang']
                ]
            ],
            [
                'nisn' => '3177531276',
                'nama_siswa' => 'ALFAREZEL RASYA HIDAYAT',
                'tempat_lahir' => 'Lima puluh kota',
                'tanggal_lahir' => '2017-11-05',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'Rahmat Hidayat', 'hubungan' => 'Ayah', 'pekerjaan' => 'wiraswasta', 'alamat' => 'Durian Gadang']]
            ],
            [
                'nisn' => '3174842061',
                'nama_siswa' => 'KURNIA ADEFA',
                'tempat_lahir' => 'Lima puluh kota',
                'tanggal_lahir' => '2017-11-16',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'Fajri', 'hubungan' => 'Ayah', 'pekerjaan' => 'wiraswasta', 'alamat' => 'Durian Gadang']]
            ],
            [
                'nisn' => '3186999762',
                'nama_siswa' => 'MARYAM',
                'tempat_lahir' => 'Lima puluh kota',
                'tanggal_lahir' => '2018-03-10',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'Zul Azmi', 'hubungan' => 'Ayah', 'pekerjaan' => 'Tani/pekebun', 'alamat' => 'Durian Gadang']]
            ],
            [
                'nisn' => '3173673721',
                'nama_siswa' => 'NADHIRA KHAIRUNNISA',
                'tempat_lahir' => 'Payakumbuh',
                'tanggal_lahir' => '2017-11-10',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'Sahrul Efendi', 'hubungan' => 'Ayah', 'pekerjaan' => 'wiraswasta', 'alamat' => 'Durian Gadang']]
            ],
            [
                'nisn' => '3172026141',
                'nama_siswa' => 'REY PRANAJA KURNIA',
                'tempat_lahir' => 'Payakumbuh',
                'tanggal_lahir' => '2017-07-03',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'Rizki Kurnia', 'hubungan' => 'Ayah', 'pekerjaan' => 'Tani/pekebun', 'alamat' => 'Durian Gadang']]
            ],
            [
                'nisn' => '3188314042',
                'nama_siswa' => 'SYAHDAN SARDINAL',
                'tempat_lahir' => 'Payakumbuh',
                'tanggal_lahir' => '2018-02-22',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'sardinal', 'hubungan' => 'Ayah', 'pekerjaan' => 'wiraswasta', 'alamat' => 'Durian Gadang']]
            ],
            [
                'nisn' => '3184762320',
                'nama_siswa' => 'ZEIN ABDUL MALIK',
                'tempat_lahir' => 'Lima puluh kota',
                'tanggal_lahir' => '2018-01-16',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat_siswa' => 'Durian Gadang',
                'wali' => [['nama_wali' => 'M. Zaid', 'hubungan' => 'Ayah', 'pekerjaan' => 'Tani/pekebun', 'alamat' => 'Durian Gadang']]
            ],
        ];

        $defaultSiswa = [
            'tempat_lahir' => '-',
            'tanggal_lahir' => '2018-01-01',
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'status_keluarga' => 'Anak Kandung',
            'anak_ke' => 1,
            'alamat_siswa' => '-',
            'telp_siswa' => '-',
            'sekolah_asal' => '-',
            'tanggal_diterima' => '2024-07-15',
        ];

        $defaultWali = [
            'hubungan' => 'Ayah',
            'alamat' => '-',
            'telepon' => '-',
            'pekerjaan' => '-',
        ];

        foreach ($siswas as $siswaData) {
            $wali = $siswaData['wali'];
            unset($siswaData['wali']);

            $siswa = Siswa::updateOrCreate(
                ['nisn' => $siswaData['nisn']],
                array_merge($defaultSiswa, $siswaData)
            );

            foreach ($wali as $w) {
                WaliSiswa::updateOrCreate(
                    ['nisn' => $siswa->nisn, 'nama_wali' => $w['nama_wali']],
                    array_merge($defaultWali, $w)
                );
            }
        }
    }
}
