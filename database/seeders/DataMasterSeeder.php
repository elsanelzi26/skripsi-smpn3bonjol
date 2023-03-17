<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\DataMaster\Entities\AgamaModel;
use Modules\DataMaster\Entities\PendidikanModel;
use Modules\DataMaster\Entities\JenisKelaminModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jeniskelamin = JenisKelaminModel::insert(
            [
                [
                    'nama_jenis_kelamin' => 'L'
                ],
                [
                    'nama_jenis_kelamin' => 'P'
                ]
            ]
	    );

        $pendidikan = PendidikanModel::insert(
            [
                [
                    'nama_pendidikan' => 'D3'
                ],
                [
                    'nama_pendidikan' => 'D4'
                ],
                [
                    'nama_pendidikan' => 'S1'
                ]
            ]
	    );
        $agama = AgamaModel::insert(
            [
                [
                    'nama_agama' => 'Islam'
                ],
                [
                    'nama_agama' => 'Kristen'
                ],
                [
                    'nama_agama' => 'Hindu'
                ],
                [
                    'nama_agama' => 'Buddha'
                ]
            ]
	    );
    }
}
