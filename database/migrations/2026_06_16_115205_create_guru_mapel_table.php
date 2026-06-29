<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->id();

            // FK ke tb_guru
            $table->unsignedBigInteger('id_guru');

            // FK ke mapel
            $table->unsignedBigInteger('id_mapel');

            $table->foreign('id_guru')
                ->references('id')
                ->on('tb_guru')
                ->cascadeOnDelete();

            $table->foreign('id_mapel')
                ->references('id_mapel')
                ->on('mapel')
                ->cascadeOnDelete();

            $table->unique(['id_guru', 'id_mapel']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_mapel');
    }
};
