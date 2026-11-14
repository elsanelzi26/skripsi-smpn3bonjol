<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasModel extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'tb_kelas';
    protected $primaryKey = 'id_kelas';

    protected $guarded = ['id_kelas'];

    public function walas()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_walas', 'id_pegawai');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaranModel::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }
}
