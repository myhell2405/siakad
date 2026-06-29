<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasTahunAjaran extends Model
{
    protected $table = 'kelas_tahun_ajaran';

    protected $fillable = [
        'id_kelas',
        'id_tahun_ajaran',
        'id_wali_kelas',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'id_wali_kelas', 'id');
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'id_kelas_tahun_ajaran', 'id');
    }

    public function guruKelas()
    {
        return $this->hasMany(GuruKelas::class, 'id_kelas_tahun_ajaran', 'id');
    }
}
