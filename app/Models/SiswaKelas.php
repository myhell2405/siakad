<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    protected $table = 'siswa_kelas';

    protected $fillable = [
        'id_kelas_tahun_ajaran',
        'id_siswa',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function kelasTahunAjaran()
    {
        return $this->belongsTo(KelasTahunAjaran::class, 'id_kelas_tahun_ajaran', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
