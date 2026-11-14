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
        Schema::create('tb_absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->foreignId('siswa_id')->constrained('tb_siswa','id_siswa')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('tb_kelas','id_kelas');
            $table->foreignId('mapel_id')->constrained('tb_mapel','id_mapel');
            $table->foreignId('pegawai_id')->constrained('tb_pegawai','id_pegawai'); // Guru yang melakukan input
            $table->foreignId('tahun_ajaran_id')->constrained('tb_tahun_ajaran','id_tahun_ajaran');
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa']);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('tb_absensi');
    }
};
