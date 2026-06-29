<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nama_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_keluarga',
        'anak_ke',
        'alamat_siswa',
        'telp_siswa',
        'sekolah_asal',
        'tanggal_diterima',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_diterima' => 'date',
        'anak_ke' => 'integer',
    ];

    /**
     * Relasi ke tabel wali_siswa
     */
    public function waliSiswa()
    {
        return $this->hasMany(
            WaliSiswa::class,
            'nisn',
            'nisn'
        );
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'id_siswa', 'id');
    }

    /**
     * Akses kelas melalui siswa_kelas -> kelas_tahun_ajaran -> kelas
     */
    public function kelasTahunAjaran()
    {
        return $this->hasManyThrough(
            KelasTahunAjaran::class,
            SiswaKelas::class,
            'id_siswa',
            'id',
            'id',
            'id_kelas_tahun_ajaran'
        );
    }
}
