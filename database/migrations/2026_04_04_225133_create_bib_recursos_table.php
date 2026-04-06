<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_recursos', function (Blueprint $table) {
            $table->id('id_recurso');

            $table->string('codigo', 50)->unique();
            $table->string('titulo', 255);
            $table->string('subtitulo', 255)->nullable();

            $table->string('isbn', 30)->nullable();
            $table->string('issn', 30)->nullable();

            $table->unsignedSmallInteger('anio_publicacion')->nullable();
            $table->string('edicion', 100)->nullable();
            $table->unsignedInteger('numero_paginas')->nullable();

            $table->text('resumen')->nullable();
            $table->text('tabla_contenido')->nullable();
            $table->text('notas')->nullable();

            $table->unsignedBigInteger('id_editorial')->nullable();
            $table->unsignedBigInteger('id_pais')->nullable();
            $table->unsignedBigInteger('id_idioma')->nullable();
            $table->unsignedBigInteger('id_nivel_bibliografico')->nullable();
            $table->unsignedBigInteger('id_tipo_recurso');
            $table->unsignedBigInteger('id_tipo_adquisicion')->nullable();
            $table->unsignedBigInteger('id_tipo_acceso')->nullable();

            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_editorial')
                ->references('id_editorial')
                ->on('bib_editoriales')
                ->nullOnDelete();

            $table->foreign('id_pais')
                ->references('id_pais')
                ->on('bib_paises')
                ->nullOnDelete();

            $table->foreign('id_idioma')
                ->references('id_idioma')
                ->on('bib_idiomas')
                ->nullOnDelete();

            $table->foreign('id_nivel_bibliografico')
                ->references('id_nivel_bibliografico')
                ->on('bib_niveles_bibliograficos')
                ->nullOnDelete();

            $table->foreign('id_tipo_recurso')
                ->references('id_tipo_recurso')
                ->on('bib_tipos_recurso')
                ->restrictOnDelete();

            $table->foreign('id_tipo_adquisicion')
                ->references('id_tipo_adquisicion')
                ->on('bib_tipos_adquisicion')
                ->nullOnDelete();

            $table->foreign('id_tipo_acceso')
                ->references('id_tipo_acceso')
                ->on('bib_tipos_acceso')
                ->nullOnDelete();

            $table->index('titulo');
            $table->index('codigo');
            $table->index('anio_publicacion');
            $table->index('orden');
            $table->index('activo');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_recursos');
    }
};