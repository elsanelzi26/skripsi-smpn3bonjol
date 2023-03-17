<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\DataMaster\Entities\DetailUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgamaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_agama';
    protected $primaryKey = 'id_agama'; 
    // public $timestamps = false;

    protected $guarded = ['id_agama'];
    
    protected static function newFactory()
    {
        return \Modules\DataMaster\Database\factories\AgamaModelFactory::new();
    }

    public function detailuser()
    {
        return $this->hasMany('DetailUser', 'id_agama', 'id_agama');
    }
}
