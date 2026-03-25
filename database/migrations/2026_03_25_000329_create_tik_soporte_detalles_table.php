<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_soporte_detalles', function (Blueprint $table) {
            $table->bigIncrements('id_soporte_detalle');
            $table->unsignedBigInteger('id_soporte');
            $table->unsignedBigInteger('id_servicio');
            $table->unsignedBigInteger('id_incidencia')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_soporte')
                ->references('id_soporte')
                ->on('tik_soportes')
                ->cascadeOnDelete();

            $table->foreign('id_servicio')
                ->references('id_servicio')
                ->on('tik_servicios');

            $table->foreign('id_incidencia')
                ->references('id_incidencia')
                ->on('tik_incidencias')
                ->nullOnDelete();

            $table->index(['id_soporte']);
            $table->index(['id_servicio']);
            $table->index(['id_incidencia']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_soporte_detalles');
    }
};