<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliSiswa extends Model
{
    use HasFactory;

    protected $table = 'wali_siswa';

    protected $primaryKey = 'id_wali';

    protected $fillable = [
        'nisn',
        'nama_wali',
        'hubungan',
        'alamat',
        'telepon',
        'pekerjaan',
    ];

    /**
     * Relasi ke tabel siswa
     */
    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'nisn',
            'nisn'
        );
    }
}
