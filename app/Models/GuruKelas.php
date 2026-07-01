<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruKelas extends Model
{
    protected $table = 'guru_kelas';

    protected $fillable = [
        'id_kelas_tahun_ajaran',
        'id_guru_mapel',
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

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'id_guru_mapel', 'id');
    }
}
