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
        Schema::create('tb_user_pemohon', function (Blueprint $table) {
            $table->id('id_user_pemohon');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_pemohon', 150);
            $table->char('nik', 16)->unique();
            $table->string('npwp', 50)->unique();
            $table->text('alamat_pemohon');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->text('rt');
            $table->text('rw');
            $table->string('nomor_telepon', 15);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('id_user')->on('tb_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_user_pemohon');
    }
};
