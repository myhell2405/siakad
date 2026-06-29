<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $primaryKey = 'id_tahun_ajaran';

    protected $fillable = [
        'tahun_mulai',
        'tahun_selesai',
        'semester',
        'status',
    ];

    public function kelasTahunAjaran()
    {
        return $this->hasMany(
            KelasTahunAjaran::class,
            'id_tahun_ajaran',
            'id_tahun_ajaran'
        );
    }

    public function getTahunAjaranAttribute()
    {
        return $this->tahun_mulai . '/' . $this->tahun_selesai;
    }
}
