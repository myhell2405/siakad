<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_guru', function (Blueprint $table) {
            $table->id();

            $table->string('nip', 20)->unique();
            $table->string('nuptk', 20)->nullable()->unique();
            $table->string('nama_lengkap', 100);

            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');

            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->string('pendidikan_terakhir', 10);
            $table->string('jabatan_guru', 50);
            $table->string('pangkat_gol', 50)->nullable();

            $table->text('alamat');

            $table->string('kenagarian', 50);
            $table->string('kecamatan', 50);
            $table->string('kab_kota', 50);
            $table->string('provinsi', 50);

            $table->string('no_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();

            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_guru');
    }
};
