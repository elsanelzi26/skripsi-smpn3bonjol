<?php

namespace Modules\DataMaster\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_role';
    protected $primaryKey = 'id_role';

    protected $guarded = ['id_role'];
}
