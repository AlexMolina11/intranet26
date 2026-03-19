<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | tik_tipos_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_tipos_ticket', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');

            $table->index('deleted_at', 'idx_tik_tipos_ticket_deleted_at');
            $table->index('id_area_responsable', 'idx_tik_tipos_ticket_area_responsable');

            $table->foreign('id_area_responsable', 'fk_tik_tipos_ticket_area_responsable')
                ->references('id_area')
                ->on('org_areas')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_incidencias
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_incidencias', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');

            $table->index('deleted_at', 'idx_tik_incidencias_deleted_at');
            $table->index('id_area_responsable', 'idx_tik_incidencias_area_responsable');

            $table->foreign('id_area_responsable', 'fk_tik_incidencias_area_responsable')
                ->references('id_area')
                ->on('org_areas')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_tipos_servicio
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_tipos_servicio', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');

            $table->index('deleted_at', 'idx_tik_tipos_servicio_deleted_at');
            $table->index('id_area_responsable', 'idx_tik_tipos_servicio_area_responsable');

            $table->foreign('id_area_responsable', 'fk_tik_tipos_servicio_area_responsable')
                ->references('id_area')
                ->on('org_areas')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_servicios
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_servicios', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->index('deleted_at', 'idx_tik_servicios_deleted_at');
        });

        /*
        |--------------------------------------------------------------------------
        | tik_formatos_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_formatos_ticket', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->index('deleted_at', 'idx_tik_formatos_ticket_deleted_at');
        });

        /*
        |--------------------------------------------------------------------------
        | tik_estados_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_estados_ticket', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->index('deleted_at', 'idx_tik_estados_ticket_deleted_at');
        });

        /*
        |--------------------------------------------------------------------------
        | tik_flujos_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_flujos_ticket', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->index('deleted_at', 'idx_tik_flujos_ticket_deleted_at');
        });

        /*
        |--------------------------------------------------------------------------
        | tik_tipos_ticket_rrhh
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_tipos_ticket_rrhh', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->index('deleted_at', 'idx_tik_tipos_ticket_rrhh_deleted_at');
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | tik_tipos_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_tipos_ticket', function (Blueprint $table) {
            $table->dropForeign('fk_tik_tipos_ticket_area_responsable');
            $table->dropIndex('idx_tik_tipos_ticket_deleted_at');
            $table->dropIndex('idx_tik_tipos_ticket_area_responsable');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_incidencias
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_incidencias', function (Blueprint $table) {
            $table->dropForeign('fk_tik_incidencias_area_responsable');
            $table->dropIndex('idx_tik_incidencias_deleted_at');
            $table->dropIndex('idx_tik_incidencias_area_responsable');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_tipos_servicio
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_tipos_servicio', function (Blueprint $table) {
            $table->dropForeign('fk_tik_tipos_servicio_area_responsable');
            $table->dropIndex('idx_tik_tipos_servicio_deleted_at');
            $table->dropIndex('idx_tik_tipos_servicio_area_responsable');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_servicios
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_servicios', function (Blueprint $table) {
            $table->dropIndex('idx_tik_servicios_deleted_at');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_formatos_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_formatos_ticket', function (Blueprint $table) {
            $table->dropIndex('idx_tik_formatos_ticket_deleted_at');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_estados_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_estados_ticket', function (Blueprint $table) {
            $table->dropIndex('idx_tik_estados_ticket_deleted_at');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_flujos_ticket
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_flujos_ticket', function (Blueprint $table) {
            $table->dropIndex('idx_tik_flujos_ticket_deleted_at');
            $table->dropSoftDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | tik_tipos_ticket_rrhh
        |--------------------------------------------------------------------------
        */
        Schema::table('tik_tipos_ticket_rrhh', function (Blueprint $table) {
            $table->dropIndex('idx_tik_tipos_ticket_rrhh_deleted_at');
            $table->dropSoftDeletes();
        });
    }
};