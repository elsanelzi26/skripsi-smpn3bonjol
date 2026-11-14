<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataPelajaranModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_mapel';
    protected $primaryKey = 'id_mapel';

    protected $guarded = ['id_mapel'];
}
