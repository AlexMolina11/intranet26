<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_soportes', function (Blueprint $table) {
            $table->bigIncrements('id_soporte');

            $table->unsignedBigInteger('id_ticket')->nullable();
            $table->unsignedBigInteger('id_usuario_gestor');
            $table->unsignedBigInteger('id_usuario_solicitante');
            $table->unsignedBigInteger('id_departamento');
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->unsignedBigInteger('id_seccion')->nullable();
            $table->unsignedBigInteger('id_servicio')->nullable();
            $table->unsignedBigInteger('id_incidencia')->nullable();

            $table->enum('tipo_registro', ['TICKET', 'AVANCE', 'EXTERNO'])->default('TICKET');

            $table->string('asunto', 255);
            $table->text('descripcion');

            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->dateTime('notificado_at')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ticket')
                ->references('id_ticket')
                ->on('tik_tickets')
                ->nullOnDelete();

            $table->foreign('id_usuario_gestor')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_usuario_solicitante')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_departamento')
                ->references('id_departamento')
                ->on('org_departamentos');

            $table->foreign('id_proyecto')
                ->references('id_proyecto')
                ->on('org_proyectos')
                ->nullOnDelete();

            $table->foreign('id_seccion')
                ->references('id_seccion')
                ->on('tik_secciones')
                ->nullOnDelete();

            $table->foreign('id_servicio')
                ->references('id_servicio')
                ->on('tik_servicios')
                ->nullOnDelete();

            $table->foreign('id_incidencia')
                ->references('id_incidencia')
                ->on('tik_incidencias')
                ->nullOnDelete();

            $table->index(['id_ticket']);
            $table->index(['id_usuario_gestor']);
            $table->index(['id_usuario_solicitante']);
            $table->index(['id_departamento']);
            $table->index(['id_proyecto']);
            $table->index(['tipo_registro']);
            $table->index(['notificado_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_soportes');
    }
};