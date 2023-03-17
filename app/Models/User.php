<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Modules\DataMaster\Entities\DetailUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DataMaster\Entities\UserPemohonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user'; 
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  

    public function detailuser()
    {
        return $this->hasMany('DetailUser', 'id_user', 'id_user');
    }

    public function userpemohon()
    {
        return $this->hasMany('UserPemohonModel', 'id_user', 'id_user');
    }
}
