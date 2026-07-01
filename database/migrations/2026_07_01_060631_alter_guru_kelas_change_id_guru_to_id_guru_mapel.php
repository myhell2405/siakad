<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('guru_kelas');

        Schema::create('guru_kelas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_kelas_tahun_ajaran');
            $table->unsignedBigInteger('id_guru_mapel');

            $table->timestamps();

            $table->foreign('id_kelas_tahun_ajaran')
                ->references('id')
                ->on('kelas_tahun_ajaran')
                ->onDelete('cascade');

            $table->foreign('id_guru_mapel')
                ->references('id')
                ->on('guru_mapel')
                ->onDelete('cascade');

            $table->unique(['id_kelas_tahun_ajaran', 'id_guru_mapel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_kelas');

        Schema::create('guru_kelas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_kelas_tahun_ajaran');
            $table->unsignedBigInteger('id_guru');

            $table->timestamps();

            $table->foreign('id_kelas_tahun_ajaran')
                ->references('id')
                ->on('kelas_tahun_ajaran')
                ->onDelete('cascade');

            $table->foreign('id_guru')
                ->references('id')
                ->on('tb_guru')
                ->onDelete('cascade');

            $table->unique(['id_kelas_tahun_ajaran', 'id_guru']);
        });
    }
};
