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
        Schema::create('tb_siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('ortu_id')->nullable()->constrained('users', 'id_user');
            $table->foreignId('kelas_id')->constrained('tb_kelas','id_kelas');
            $table->string('nisn', 10)->unique();
            $table->string('nama', 100);
            $table->enum('jk', ['L', 'P']);
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
        Schema::dropIfExists('tb_siswa');
    }
};
