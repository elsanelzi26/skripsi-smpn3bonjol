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
        Schema::create('tb_data_permohonan', function (Blueprint $table) {
            $table->id('id_data_permohonan');
            $table->unsignedBigInteger('id_user_pemohon');
            $table->string('nama_pemilik_tanah');
            $table->string('nama_pemilik_bangunan');
            $table->text('alamat_lokasi');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rt');
            $table->string('rw');
            $table->string('luas_tanah_yang_dimohon');
            $table->string('luas_bangunan_yang_dimohon');
            $table->string('nama_usaha');
            $table->integer('modal_usaha');
            $table->string('skala_usaha');
            $table->string('tingkat_resiko');
            $table->string('ktp');
            $table->string('sppt_dan_pbb');
            $table->string('bukti_kepemilikan');
            $table->string('denah_lokasi');
            $table->string('lembar_bidang_tanah');
            $table->string('status_permohonan');
            $table->string('tanggal_pemohon');
            $table->string('tanggal_terbit')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('isi_disposisi')->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('id_user_pemohon')->references('id_user_pemohon')->on('tb_user_pemohon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_data_permohonan');
    }
};
