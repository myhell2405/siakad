<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');

            $table->string('username', 50)->unique();
            $table->string('password', 255);

            // relasi role
            $table->unsignedBigInteger('role_id');

            // relasi ke guru / siswa (opsional)
            $table->unsignedBigInteger('ref_id')->nullable();

            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();

            // foreign key
            $table->foreign('role_id')
                ->references('id_role')
                ->on('tb_role')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
