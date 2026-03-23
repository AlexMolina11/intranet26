<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tik_tickets', function (Blueprint $table) {
            $table->boolean('es_proyecto')->default(false)->after('id_servicio');
            $table->boolean('no_aplica')->default(false)->after('es_proyecto');
            $table->unsignedBigInteger('id_usuario_asignador')->nullable()->after('id_usuario_responsable');

            $table->foreign('id_usuario_asignador', 'fk_tik_ticket_usuario_asignador')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->index(['id_area_responsable', 'id_estado_ticket'], 'idx_tik_tickets_area_estado');
            $table->index(['id_usuario_responsable', 'id_estado_ticket'], 'idx_tik_tickets_responsable_estado');
        });
    }

    public function down(): void
    {
        Schema::table('tik_tickets', function (Blueprint $table) {
            $table->dropForeign('fk_tik_ticket_usuario_asignador');
            $table->dropIndex('idx_tik_tickets_area_estado');
            $table->dropIndex('idx_tik_tickets_responsable_estado');

            $table->dropColumn([
                'es_proyecto',
                'no_aplica',
                'id_usuario_asignador',
            ]);
        });
    }
};