<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_tickets', function (Blueprint $table) {
            $table->bigIncrements('id_ticket');

            $table->string('codigo', 30)->nullable()->unique();

            $table->unsignedBigInteger('id_usuario_solicitante');
            $table->unsignedBigInteger('id_usuario_responsable')->nullable();

            $table->unsignedBigInteger('id_area_solicitante')->nullable();
            $table->unsignedBigInteger('id_area_responsable')->nullable();

            $table->unsignedBigInteger('id_tipo_ticket');
            $table->unsignedBigInteger('id_tipo_ticket_rrhh')->nullable();
            $table->unsignedBigInteger('id_formato_ticket');
            $table->unsignedBigInteger('id_estado_ticket');
            $table->unsignedBigInteger('id_incidencia')->nullable();
            $table->unsignedBigInteger('id_servicio')->nullable();

            $table->string('asunto', 180);
            $table->longText('descripcion');

            $table->timestamp('fecha_ticket')->useCurrent();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->timestamp('fecha_cierre')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_usuario_solicitante', 'fk_tik_ticket_usuario_solicitante')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario_responsable', 'fk_tik_ticket_usuario_responsable')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_area_solicitante', 'fk_tik_ticket_area_solicitante')
                ->references('id_area')
                ->on('org_areas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_area_responsable', 'fk_tik_ticket_area_responsable')
                ->references('id_area')
                ->on('org_areas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_tipo_ticket', 'fk_tik_ticket_tipo_ticket')
                ->references('id_tipo_ticket')
                ->on('tik_tipos_ticket')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_tipo_ticket_rrhh', 'fk_tik_ticket_tipo_ticket_rrhh')
                ->references('id_tipo_ticket_rrhh')
                ->on('tik_tipos_ticket_rrhh')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_formato_ticket', 'fk_tik_ticket_formato_ticket')
                ->references('id_formato_ticket')
                ->on('tik_formatos_ticket')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_estado_ticket', 'fk_tik_ticket_estado_ticket')
                ->references('id_estado_ticket')
                ->on('tik_estados_ticket')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_incidencia', 'fk_tik_ticket_incidencia')
                ->references('id_incidencia')
                ->on('tik_incidencias')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_servicio', 'fk_tik_ticket_servicio')
                ->references('id_servicio')
                ->on('tik_servicios')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->index('deleted_at', 'idx_tik_tickets_deleted_at');
            $table->index('codigo', 'idx_tik_tickets_codigo');
            $table->index(['id_estado_ticket', 'id_tipo_ticket'], 'idx_tik_tickets_estado_tipo');
            $table->index(['id_usuario_solicitante', 'fecha_ticket'], 'idx_tik_tickets_usuario_fecha');
            $table->index(['activo', 'fecha_ticket'], 'idx_tik_tickets_activo_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_tickets');
    }
};