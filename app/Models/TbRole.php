<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbRole extends Model
{
    protected $table = 'tb_role';

    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
        'deskripsi',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    // relasi: role punya banyak user
    public function users()
    {
        return $this->hasMany(TbUser::class, 'role_id', 'id_role');
    }
}
