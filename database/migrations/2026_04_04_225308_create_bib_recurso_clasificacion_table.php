<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_recurso_clasificacion', function (Blueprint $table) {
            $table->id('id_recurso_clasificacion');
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_clasificacion');
            $table->timestamps();

            $table->foreign('id_recurso')
                ->references('id_recurso')
                ->on('bib_recursos')
                ->cascadeOnDelete();

            $table->foreign('id_clasificacion')
                ->references('id_clasificacion')
                ->on('bib_clasificaciones')
                ->restrictOnDelete();

            $table->unique(['id_recurso', 'id_clasificacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_recurso_clasificacion');
    }
};