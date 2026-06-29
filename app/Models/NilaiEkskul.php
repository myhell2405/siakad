<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiEkskul extends Model
{
    use HasFactory;

    protected $table = 'nilai_ekskul';

    protected $fillable = [
        'siswa_id',
        'kelas_tahun_ajaran_id',
        'id_ekskul',
        'predikat',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function kelasTahunAjaran()
    {
        return $this->belongsTo(KelasTahunAjaran::class, 'kelas_tahun_ajaran_id', 'id');
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'id_ekskul', 'id_ekskul');
    }
}
