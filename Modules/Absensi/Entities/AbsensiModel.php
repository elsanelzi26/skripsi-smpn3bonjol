<?php

namespace Modules\Absensi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Modules\DataMaster\Entities\PegawaiModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\TahunAjaranModel;

class AbsensiModel extends Model
{
    use HasFactory;

    protected $table = 'tb_absensi';
    protected $primaryKey = 'id_absensi';

    protected $guarded = ['id_absensi'];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'id_pegawai', 'id_pegawai');
    }

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa', 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas', 'id_kelas');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaranModel::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaranModel::class, 'id_mapel', 'id_mapel');
    }
}
