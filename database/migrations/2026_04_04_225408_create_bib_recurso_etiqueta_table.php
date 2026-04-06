<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_recurso_etiqueta', function (Blueprint $table) {
            $table->id('id_recurso_etiqueta');
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_etiqueta');
            $table->timestamps();

            $table->foreign('id_recurso')
                ->references('id_recurso')
                ->on('bib_recursos')
                ->cascadeOnDelete();

            $table->foreign('id_etiqueta')
                ->references('id_etiqueta')
                ->on('bib_etiquetas')
                ->restrictOnDelete();

            $table->unique(['id_recurso', 'id_etiqueta']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_recurso_etiqueta');
    }
};