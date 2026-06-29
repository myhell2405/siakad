<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_tahun_ajaran', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_tahun_ajaran');
            $table->unsignedBigInteger('id_wali_kelas');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            // Relasi ke tabel kelas
            $table->foreign('id_kelas')
                ->references('id_kelas')
                ->on('kelas')
                ->onDelete('cascade');

            // Relasi ke tabel tahun_ajaran
            $table->foreign('id_tahun_ajaran')
                ->references('id_tahun_ajaran')
                ->on('tahun_ajaran')
                ->onDelete('cascade');

            // Relasi ke tabel guru
            $table->foreign('id_wali_kelas')
                ->references('id')
                ->on('tb_guru')
                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            | Mencegah duplikasi kelas di tahun ajaran yang sama
            */
            $table->unique(['id_kelas', 'id_tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_tahun_ajaran');
    }
};
