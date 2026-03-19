<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_incidencias', function (Blueprint $table) {
            $table->bigIncrements('id_incidencia');
            $table->string('codigo', 60)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_area_responsable')->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['activo', 'orden'], 'idx_tik_incidencias_activo_orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_incidencias');
    }
};