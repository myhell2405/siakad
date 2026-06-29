<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    protected $table = 'guru_mapel';

    protected $fillable = [
        'id_guru',
        'id_mapel',
    ];

    // RELASI KE GURU (tb_guru)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

    // RELASI KE MAPEL
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
}
