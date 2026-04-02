<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_estados_solicitud', function (Blueprint $table) {
            $table->id('id_estado_solicitud');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('es_inicial')->default(false);
            $table->boolean('es_final')->default(false);
            $table->boolean('permite_aprobacion')->default(false);
            $table->boolean('permite_rechazo')->default(false);
            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('orden');
            $table->index('activo');
            $table->index('es_inicial');
            $table->index('es_final');
            $table->index('permite_aprobacion');
            $table->index('permite_rechazo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_estados_solicitud');
    }
};