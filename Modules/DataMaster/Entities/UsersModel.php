<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class usersModel extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user'; // Custom PK

    protected $guarded = ['id_user'];

    // Relasi ke tabel Pegawai
    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke tabel Ortu
    public function ortu()
    {
        return $this->belongsTo(OrtuModel::class, 'id_ortu', 'id_ortu');
    }

     public function role()
    {
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    // Relasi ke tabel Siswa
    public function siswa()
    {
        return $this->hasOne(SiswaModel::class, 'id_user', 'id_user');
    }
}
