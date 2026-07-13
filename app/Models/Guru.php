<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'tb_guru';

    protected $fillable = [
        'nip',
        'nuptk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'jabatan_guru',
        'pangkat_gol',
        'alamat',
        'kenagarian',
        'kecamatan',
        'kab_kota',
        'provinsi',
        'no_telepon',
        'email',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function mapel()
    {
        return $this->belongsToMany(
            Mapel::class,
            'guru_mapel',
            'id_guru',
            'id_mapel'
        );
    }

    public function ekskul()
    {
        return $this->hasMany(
            Ekskul::class,
            'id_guru',
            'id'
        );
    }

    public function guruKelas()
    {
        return $this->hasManyThrough(
            GuruKelas::class,
            GuruMapel::class,
            'id_guru',
            'id_guru_mapel',
            'id',
            'id'
        );
    }

    public function kelasTahunAjaran()
    {
        return $this->hasMany(KelasTahunAjaran::class, 'id_wali_kelas', 'id');
    }
}
