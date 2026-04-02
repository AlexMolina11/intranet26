<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_autores', function (Blueprint $table) {
            $table->id('id_autor');
            $table->string('nombre', 150);
            $table->string('apellido', 150)->nullable();
            $table->string('nombre_completo', 255);
            $table->string('seudonimo', 150)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_fallecimiento')->nullable();
            $table->text('biografia')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('apellido');
            $table->index('nombre_completo');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_autores');
    }
};