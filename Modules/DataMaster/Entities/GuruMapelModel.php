<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuruMapelModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_guru_mapel';
    protected $primaryKey = 'id_guru_mapel';

    protected $guarded = ['id_guru_mapel'];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaranModel::class, 'id_mapel', 'id_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas', 'id_kelas');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaranModel::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }
}
