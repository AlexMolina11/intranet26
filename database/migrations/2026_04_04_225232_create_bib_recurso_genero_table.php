<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_recurso_genero', function (Blueprint $table) {
            $table->id('id_recurso_genero');
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_genero');
            $table->timestamps();

            $table->foreign('id_recurso')
                ->references('id_recurso')
                ->on('bib_recursos')
                ->cascadeOnDelete();

            $table->foreign('id_genero')
                ->references('id_genero')
                ->on('bib_generos')
                ->restrictOnDelete();

            $table->unique(['id_recurso', 'id_genero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_recurso_genero');
    }
};