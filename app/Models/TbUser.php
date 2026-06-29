<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbUser extends Model
{
    protected $table = 'tb_user';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role_id',
        'ref_id',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    // relasi: user ke role
    public function role()
    {
        return $this->belongsTo(TbRole::class, 'role_id', 'id_role');
    }

    // helper: cek role cepat
    public function isRole($roleName)
    {
        return $this->role && $this->role->nama_role === $roleName;
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'ref_id', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'ref_id', 'id');
    }
}
