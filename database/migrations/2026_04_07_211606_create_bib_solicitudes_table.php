<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_solicitudes', function (Blueprint $table) {
            $table->id('id_solicitud');

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_ejemplar')->nullable();
            $table->unsignedBigInteger('id_estado_solicitud');

            $table->date('fecha_solicitud');
            $table->date('fecha_requerida')->nullable();
            $table->date('fecha_atencion')->nullable();

            $table->text('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('observaciones_internas')->nullable();

            $table->unsignedBigInteger('id_usuario_atiende')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete();

            $table->foreign('id_recurso')
                ->references('id_recurso')
                ->on('bib_recursos')
                ->restrictOnDelete();

            $table->foreign('id_ejemplar')
                ->references('id_ejemplar')
                ->on('bib_ejemplares')
                ->nullOnDelete();

            $table->foreign('id_estado_solicitud')
                ->references('id_estado_solicitud')
                ->on('bib_estados_solicitud')
                ->restrictOnDelete();

            $table->foreign('id_usuario_atiende')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete();

            $table->index('id_usuario');
            $table->index('id_recurso');
            $table->index('id_ejemplar');
            $table->index('id_estado_solicitud');
            $table->index('id_usuario_atiende');
            $table->index('fecha_solicitud');
            $table->index('fecha_requerida');
            $table->index('fecha_atencion');
            $table->index('activo');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_solicitudes');
    }
};