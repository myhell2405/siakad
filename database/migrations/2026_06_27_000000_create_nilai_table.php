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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('id_mapel');
            $table->unsignedBigInteger('kelas_tahun_ajaran_id');

            $table->float('nilai_tugas')->nullable();
            $table->float('nilai_uts')->nullable();
            $table->float('nilai_uas')->nullable();
            $table->float('nilai_akhir')->nullable();
            $table->text('catatan_guru')->nullable();
            $table->enum('status_validasi', ['draft', 'submitted', 'validated'])->default('draft');

            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->onDelete('cascade');
            $table->foreign('kelas_tahun_ajaran_id')->references('id')->on('kelas_tahun_ajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
