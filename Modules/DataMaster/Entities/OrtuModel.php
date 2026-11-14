<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrtuModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_ortu';
    protected $primaryKey = 'id_ortu';

    protected $guarded = ['id_ortu'];

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa', 'id_siswa');
    }

    public function user()
    {
        return $this->hasOne(UsersModel::class, 'id_ortu', 'id_ortu');
    }

}
