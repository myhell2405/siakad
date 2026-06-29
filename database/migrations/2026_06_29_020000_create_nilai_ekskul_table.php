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
        Schema::create('nilai_ekskul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('kelas_tahun_ajaran_id');
            $table->unsignedBigInteger('id_ekskul');
            
            $table->string('predikat', 50)->default('Baik'); // e.g. Sangat Baik, Baik, Cukup
            $table->text('keterangan')->nullable(); // e.g. Mengikuti kegiatan dengan aktif dan disiplin

            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('kelas_tahun_ajaran_id')->references('id')->on('kelas_tahun_ajaran')->onDelete('cascade');
            $table->foreign('id_ekskul')->references('id_ekskul')->on('ekskul')->onDelete('cascade');

            $table->unique(['siswa_id', 'kelas_tahun_ajaran_id', 'id_ekskul'], 'unique_siswa_kta_ekskul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ekskul');
    }
};
