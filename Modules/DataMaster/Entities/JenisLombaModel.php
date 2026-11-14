<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisLombaModel extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'tb_jenis_lomba';
    protected $primaryKey = 'id_jenis_lomba';

    protected $guarded = ['id_jenis_lomba'];
}
