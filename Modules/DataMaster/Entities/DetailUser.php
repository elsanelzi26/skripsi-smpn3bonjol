<?php

namespace Modules\DataMaster\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\DataMaster\Entities\AgamaModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DataMaster\Entities\PendidikanModel;
use Modules\DataMaster\Entities\JenisKelaminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_detail_user';
    protected $primaryKey = 'id_detail_user'; 
    // public $timestamps = false;

    protected $guarded = ['id_detail_user'];
    
    protected static function newFactory()
    {
        return \Modules\DataMaster\Database\factories\DetailUserFactory::new();
    }

    public function user()
    {
        return $this->belongsTo('User', 'id_user', 'id_user');
    }

    public function jeniskelamin()
    {
        return $this->belongsTo('JenisKelaminModel', 'id_jenis_kelamin', 'id_jenis_kelamin');
    }

    public function pendidikan()
    {
        return $this->belongsTo('PendidikanModel', 'id_pendidikan', 'id_pendidikan');
    }


    public function agama()
    {
        return $this->belongsTo('AgamaModel', 'id_agama', 'id_agama');
    }
}
