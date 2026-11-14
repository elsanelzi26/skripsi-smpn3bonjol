<?php

namespace Modules\Penilaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\SiswaModel;

class RekapMasalahModel extends Model
{
     protected $table = 'tb_rekap_masalah';
    protected $primaryKey = 'id_rekap_masalah';

    protected $guarded = ['id_rekap_masalah'];

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa', 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas', 'id_kelas');
    }

}
