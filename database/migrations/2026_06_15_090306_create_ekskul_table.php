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
        Schema::create('ekskul', function (Blueprint $table) {
            $table->id('id_ekskul');

            $table->string('nama_ekskul');

            $table->text('keterangan')->nullable();

            // Guru Pembina
            $table->unsignedBigInteger('id_guru')->nullable();

            $table->foreign('id_guru')
                ->references('id')
                ->on('tb_guru')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskul');
    }
};
