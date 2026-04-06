<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_recurso_autor', function (Blueprint $table) {
            $table->id('id_recurso_autor');
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_autor');
            $table->unsignedInteger('orden')->default(1);
            $table->timestamps();

            $table->foreign('id_recurso')
                ->references('id_recurso')
                ->on('bib_recursos')
                ->cascadeOnDelete();

            $table->foreign('id_autor')
                ->references('id_autor')
                ->on('bib_autores')
                ->restrictOnDelete();

            $table->unique(['id_recurso', 'id_autor']);
            $table->index('orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_recurso_autor');
    }
};