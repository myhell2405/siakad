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
        Schema::create('wali_siswa', function (Blueprint $table) {
            $table->id('id_wali');

            $table->string('nisn');

            $table->string('nama_wali');

            $table->enum('hubungan', [
                'AYAH',
                'IBU',
                'WALI',
            ]);

            $table->text('alamat')->nullable();

            $table->string('telepon', 20)->nullable();

            $table->string('pekerjaan', 100)->nullable();

            $table->timestamps();

            $table->foreign('nisn')
                ->references('nisn')
                ->on('siswa')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_siswa');
    }
};
