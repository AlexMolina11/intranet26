<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_encuestas_soporte', function (Blueprint $table) {
            $table->bigIncrements('id_encuesta_soporte');

            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_usuario');

            $table->unsignedTinyInteger('calificacion');
            $table->text('comentario')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ticket', 'fk_tik_encuesta_ticket')
                ->references('id_ticket')
                ->on('tik_tickets')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario', 'fk_tik_encuesta_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('deleted_at', 'idx_tik_encuestas_soporte_deleted_at');
            $table->index(['id_ticket', 'id_usuario'], 'idx_tik_encuestas_ticket_usuario');
            $table->unique('id_ticket', 'uk_tik_encuesta_ticket');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_encuestas_soporte');
    }
};