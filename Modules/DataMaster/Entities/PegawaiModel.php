<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PegawaiModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $guarded = ['id_pegawai'];

    public function user()
    {
        return $this->hasOne(UsersModel::class, 'id_pegawai', 'id_pegawai');
    }

   
    // Relasi sebagai Wali Kelas
    public function kelas()
    {
        return $this->hasOne(KelasModel::class, 'id_pegawai', 'id_pegawai');
    }
}
