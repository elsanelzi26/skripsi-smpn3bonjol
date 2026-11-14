<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\DataMaster\Entities\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detailuser = UserModel::insert([
            'id_user' => 1,
            'username' => 'admin',
            'nama_lengkap' => 'admin 1',
            'password' => Hash::make('12345678'),
            'email' => 'admin@gmail.com',
            'no_telp' => '0831432566236',
            'role' => '1',
        ]);
    }
}
