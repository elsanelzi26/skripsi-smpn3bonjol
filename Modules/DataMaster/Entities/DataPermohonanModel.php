<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DataMaster\Entities\UserPemohonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPermohonanModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_data_permohonan';
    protected $primaryKey = 'id_data_permohonan'; 
    // public $timestamps = false;

    protected $guarded = ['id_data_permohonan'];
    
    protected static function newFactory()
    {
        return \Modules\DataMaster\Database\factories\DataPermohonanModelFactory::new();
    }

    public function userpemohon()
    {
        return $this->belongsTo('UserPemohonModel', 'id_user_pemohon', 'id_user_pemohon');
    }
}
