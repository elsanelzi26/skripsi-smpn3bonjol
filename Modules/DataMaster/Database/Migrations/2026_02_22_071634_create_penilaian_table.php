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
        Schema::create('tb_penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('siswa_id')->constrained('tb_siswa','id_siswa');
            $table->foreignId('mapel_id')->constrained('tb_mapel','id_mapel');
            $table->foreignId('tahun_ajaran_id')->constrained('tb_tahun_ajaran','id_tahun_ajaran');
            $table->decimal('nilai_tugas', 5, 2)->default(0);
            $table->decimal('nilai_uts', 5, 2)->default(0);
            $table->decimal('nilai_uas', 5, 2)->default(0);
            $table->boolean('is_final')->default(false); // Status untuk rekap
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
        Schema::dropIfExists('tb_penilaian');
    }
};
