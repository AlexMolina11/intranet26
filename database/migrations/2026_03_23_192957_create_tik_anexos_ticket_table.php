<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_anexos_ticket', function (Blueprint $table) {
            $table->bigIncrements('id_anexo_ticket');

            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_usuario');

            $table->string('nombre_original', 255);
            $table->string('nombre_archivo', 255);
            $table->string('ruta_archivo', 255);
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('peso_bytes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ticket', 'fk_tik_anexo_ticket')
                ->references('id_ticket')
                ->on('tik_tickets')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_usuario', 'fk_tik_anexo_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('deleted_at', 'idx_tik_anexos_ticket_deleted_at');
            $table->index(['id_ticket', 'created_at'], 'idx_tik_anexos_ticket_ticket_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_anexos_ticket');
    }
};