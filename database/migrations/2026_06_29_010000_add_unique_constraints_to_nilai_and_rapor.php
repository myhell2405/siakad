<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan unique constraint untuk mencegah duplikat data
     * pada tabel nilai dan rapor.
     */
    public function up(): void
    {
        // BUG-8: Mencegah duplikat nilai untuk siswa-mapel-kelas yang sama
        Schema::table('nilai', function (Blueprint $table) {
            $table->unique(['siswa_id', 'id_mapel', 'kelas_tahun_ajaran_id'], 'nilai_siswa_mapel_kta_unique');
        });

        // BUG-9: Mencegah duplikat rapor untuk siswa-kelas yang sama
        Schema::table('rapor', function (Blueprint $table) {
            $table->unique(['siswa_id', 'kelas_tahun_ajaran_id'], 'rapor_siswa_kta_unique');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropUnique('nilai_siswa_mapel_kta_unique');
        });

        Schema::table('rapor', function (Blueprint $table) {
            $table->dropUnique('rapor_siswa_kta_unique');
        });
    }
};
