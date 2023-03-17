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
        Schema::create('tb_detail_user', function (Blueprint $table) {
            $table->id('id_detail_user');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_lengkap', 150);
            $table->unsignedBigInteger('id_jenis_kelamin');
            $table->unsignedBigInteger('id_pendidikan');
            $table->unsignedBigInteger('id_agama');
            $table->string('nomor_telepon', 15);
            $table->text('alamat');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('id_user')->on('tb_user');
            $table->foreign('id_jenis_kelamin')->references('id_jenis_kelamin')->on('tb_jenis_kelamin');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('tb_pendidikan');
            $table->foreign('id_agama')->references('id_agama')->on('tb_agama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detail_user');
    }
};
