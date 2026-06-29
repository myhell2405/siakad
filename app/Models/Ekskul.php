<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $table = 'ekskul';

    protected $primaryKey = 'id_ekskul';

    protected $fillable = [
        'nama_ekskul',
        'keterangan',
        'id_guru',
    ];

    /**
     * Relasi ke Guru Pembina
     */
    public function guru()
    {
        return $this->belongsTo(
            Guru::class,
            'id_guru',
            'id'
        );
    }
}
