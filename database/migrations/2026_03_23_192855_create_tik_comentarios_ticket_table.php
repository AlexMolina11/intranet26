<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_comentarios_ticket', function (Blueprint $table) {
            $table->bigIncrements('id_comentario_ticket');

            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_usuario');

            $table->text('comentario');
            $table->boolean('es_interno')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ticket', 'fk_tik_comentario_ticket')
                ->references('id_ticket')
                ->on('tik_tickets')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario', 'fk_tik_comentario_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('deleted_at', 'idx_tik_comentarios_ticket_deleted_at');
            $table->index(['id_ticket', 'created_at'], 'idx_tik_comentarios_ticket_ticket_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_comentarios_ticket');
    }
};