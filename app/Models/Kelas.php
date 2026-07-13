<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat_kelas',
    ];

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'id_kelas', 'id_kelas');
    }

    public function siswa()
    {
        return $this->belongsToMany(
            Siswa::class,
            'siswa_kelas',
            'id_kelas',
            'id_siswa'
        );
    }



    public function kelasTahunAjaran()
    {
        return $this->hasMany(KelasTahunAjaran::class, 'id_kelas', 'id_kelas');
    }
}
