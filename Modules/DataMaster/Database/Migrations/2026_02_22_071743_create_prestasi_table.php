<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->foreignId('id_siswa')->constrained('tb_siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_jenis_lomba')->constrained('tb_jenis_lomba', 'id_jenis_lomba');
            $table->string('nama_kegiatan', 150); // Lomba OSN Matematika
            $table->string('peringkat', 20);      //  Juara 1, Harapan 2
            $table->string('tingkat', 50);        //  Kecamatan, Kota, Nasional
            $table->date('tanggal_pelaksanaan');
            $table->string('sertifikat_lomba')->nullable(); //  file foto sertifikat
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_prestasi');
    }
};
