<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';

    protected $primaryKey = 'id_mapel';

    protected $fillable = [
        'nama_mapel',
        'kkm',
    ];

    public function guru()
    {
        return $this->belongsToMany(
            Guru::class,
            'guru_mapel',
            'id_mapel',
            'id_guru'
        );
    }
}
