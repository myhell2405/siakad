<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('kelas_tahun_ajaran_id');

            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpa')->default(0);
            $table->text('catatan_wali_kelas')->nullable();
            $table->string('status_kenaikan', 50)->nullable(); // e.g. 'Naik Kelas', 'Tidak Naik Kelas'

            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('kelas_tahun_ajaran_id')->references('id')->on('kelas_tahun_ajaran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapor');
    }
};
