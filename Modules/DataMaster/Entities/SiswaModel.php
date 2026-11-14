<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Absensi\Entities\AbsensiModel;
use Modules\Penilaian\Entities\PenilaianModel;

class SiswaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_siswa';
    protected $primaryKey = 'id_siswa';

    protected $guarded = ['id_siswa'];

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas', 'id_kelas');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaranModel::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    // Di dalam SiswaModel
    public function absensi()
    {
        // Mengasumsikan nama field FK di tb_absensi adalah siswa_id
        return $this->hasMany(AbsensiModel::class, 'id_siswa', 'id_siswa');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianModel::class, 'id_siswa', 'id_siswa');
    }
}
