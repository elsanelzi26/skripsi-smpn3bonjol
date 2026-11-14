<?php

namespace Modules\Penilaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DataMaster\Entities\JenisLombaModel;
use Modules\DataMaster\Entities\SiswaModel;

class PrestasiModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $guarded = ['id_prestasi'];


    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa', 'id_siswa');
    }

    public function jenis_lomba()
    {
        return $this->belongsTo(JenisLombaModel::class, 'id_jenis_lomba', 'id_jenis_lomba');
    }

}
