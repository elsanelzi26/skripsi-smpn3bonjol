<?php

namespace Modules\DataMaster\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DataMaster\Entities\DataPermohonanModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPemohonModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_user_pemohon';
    protected $primaryKey = 'id_user_pemohon'; 
    // public $timestamps = false;

    protected $guarded = ['id_user_pemohon'];
    
    
    protected static function newFactory()
    {
        return \Modules\DataMaster\Database\factories\UserPemohonModelFactory::new();
    }

    public function datapermohonan()
    {
        return $this->hasMany('DataPermohonanModel', 'id_user_pemohon', 'id_user_pemohon');
    }

}
