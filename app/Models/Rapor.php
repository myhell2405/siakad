<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    protected $table = 'rapor';

    protected $fillable = [
        'siswa_id',
        'kelas_tahun_ajaran_id',
        'sakit',
        'izin',
        'alpa',
        'catatan_wali_kelas',
        'status_kenaikan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function kelasTahunAjaran()
    {
        return $this->belongsTo(KelasTahunAjaran::class, 'kelas_tahun_ajaran_id', 'id');
    }
}
