<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_estados_prestamo', function (Blueprint $table) {
            $table->id('id_estado_prestamo');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('es_inicial')->default(false);
            $table->boolean('es_final')->default(false);
            $table->boolean('genera_multa')->default(false);
            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('orden');
            $table->index('activo');
            $table->index('es_inicial');
            $table->index('es_final');
            $table->index('genera_multa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_estados_prestamo');
    }
};