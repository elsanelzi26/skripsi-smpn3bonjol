<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\DataMaster\Entities\DetailUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DetailUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::insertGetId(
	        [
            'username' => '123456789101234567',
            'password' => Hash::make('12345678'),
            'email' => 'user1@gmail.com',
            'role' => '1'
            ]
	    );

        $detailuser = DetailUser::insert([
            'id_user' => $user,
            'nama_lengkap' => 'user1 va',
            'id_jenis_kelamin' => '1',
            'id_pendidikan' => '2',
            'id_agama' => '1',
            'nomor_telepon' => '085634215422',
            'alamat' => 'Padang'
        ]);
    }
}
