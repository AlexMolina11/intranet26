<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_flujos_ticket', function (Blueprint $table) {
            $table->bigIncrements('id_flujo_ticket');
            $table->unsignedBigInteger('id_tipo_ticket');
            $table->unsignedBigInteger('id_estado_ticket');
            $table->text('mensaje_usuario')->nullable();
            $table->text('mensaje_admin')->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_tipo_ticket', 'fk_tik_flujo_ticket_tipo')
                ->references('id_tipo_ticket')
                ->on('tik_tipos_ticket')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_estado_ticket', 'fk_tik_flujo_ticket_estado')
                ->references('id_estado_ticket')
                ->on('tik_estados_ticket')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->unique(
                ['id_tipo_ticket', 'id_estado_ticket'],
                'uq_tik_flujo_ticket_tipo_estado'
            );

            $table->index(['id_tipo_ticket', 'activo', 'orden'], 'idx_tik_flujo_tipo_activo_orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_flujos_ticket');
    }
};