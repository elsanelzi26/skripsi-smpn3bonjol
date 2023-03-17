<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\DataMaster\Entities\DetailUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisKelaminModel extends Model
{
  
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_kelamin';
    protected $primaryKey = 'id_jenis_kelamin'; 
    // public $timestamps = false;

    protected $guarded = ['id_jenis_kelamin'];
    protected static function newFactory()
    {
        return \Modules\DataMaster\Database\factories\JenisKelaminModelFactory::new();
    }

    public function detailuser()
    {
        return $this->hasMany('DetailUser', 'id_jenis_kelamin', 'id_jenis_kelamin');
    }
}
