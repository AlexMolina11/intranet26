<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_seguimientos_ticket', function (Blueprint $table) {
            $table->bigIncrements('id_seguimiento_ticket');

            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_estado_ticket_anterior')->nullable();
            $table->unsignedBigInteger('id_estado_ticket_nuevo');
            $table->text('comentario')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ticket', 'fk_tik_seguimiento_ticket')
                ->references('id_ticket')
                ->on('tik_tickets')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario', 'fk_tik_seguimiento_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_estado_ticket_anterior', 'fk_tik_seguimiento_estado_anterior')
                ->references('id_estado_ticket')
                ->on('tik_estados_ticket')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_estado_ticket_nuevo', 'fk_tik_seguimiento_estado_nuevo')
                ->references('id_estado_ticket')
                ->on('tik_estados_ticket')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('deleted_at', 'idx_tik_seguimientos_ticket_deleted_at');
            $table->index(['id_ticket', 'created_at'], 'idx_tik_seguimientos_ticket_ticket_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_seguimientos_ticket');
    }
};