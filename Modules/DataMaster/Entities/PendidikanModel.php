<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\DataMaster\Entities\DetailUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendidikanModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_pendidikan';
    protected $primaryKey = 'id_pendidikan'; 
    // public $timestamps = false;

    protected $guarded = ['id_pendidikan'];
    
    protected static function newFactory()
    {
        return \Modules\DataMaster\Database\factories\PendidikanModelFactory::new();
    }

    public function detailuser()
    {
        return $this->hasMany('DetailUser', 'id_pendidikan', 'id_pendidikan');
    }
}
