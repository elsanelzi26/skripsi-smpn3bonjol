<?php

namespace Modules\DataMaster\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\DataMaster\Entities\DetailUser;
use Modules\DataMaster\Database\Seeders\DetailUserSeederTableSeeder;

class DetailUserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $user = User::insertGetId(
	        [
            'username' => '123456789101234567',
            'password' => bcrypt('12345678'),
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

        $this->call("DetailUserSeederTableSeeder");
    }
}
