<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_kelas_tahun_ajaran');
            $table->unsignedBigInteger('id_siswa');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            // Relasi ke kelas_tahun_ajaran
            $table->foreign('id_kelas_tahun_ajaran')
                ->references('id')
                ->on('kelas_tahun_ajaran')
                ->onDelete('cascade');

            // Relasi ke siswa
            $table->foreign('id_siswa')
                ->references('id')
                ->on('siswa')
                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            | Mencegah siswa dobel dalam kelas yang sama
            */
            $table->unique(['id_kelas_tahun_ajaran', 'id_siswa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_kelas');
    }
};
