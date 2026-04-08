<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_prestamos', function (Blueprint $table) {
            $table->id('id_prestamo');

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_recurso');
            $table->unsignedBigInteger('id_ejemplar');
            $table->unsignedBigInteger('id_estado_prestamo');
            $table->unsignedBigInteger('id_solicitud')->nullable();

            $table->unsignedBigInteger('id_usuario_entrega')->nullable();
            $table->unsignedBigInteger('id_usuario_recibe')->nullable();

            $table->date('fecha_prestamo');
            $table->date('fecha_vencimiento');
            $table->date('fecha_devolucion')->nullable();

            $table->unsignedInteger('dias_autorizados')->default(0);
            $table->unsignedInteger('renovaciones_usadas')->default(0);
            $table->unsignedInteger('renovaciones_maximas')->default(0);

            $table->decimal('multa_diaria', 10, 2)->default(0);
            $table->decimal('multa_acumulada', 10, 2)->default(0);

            $table->text('observaciones')->nullable();
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
                ->restrictOnDelete();

            $table->foreign('id_estado_prestamo')
                ->references('id_estado_prestamo')
                ->on('bib_estados_prestamo')
                ->restrictOnDelete();

            $table->foreign('id_solicitud')
                ->references('id_solicitud')
                ->on('bib_solicitudes')
                ->nullOnDelete();

            $table->foreign('id_usuario_entrega')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete();

            $table->foreign('id_usuario_recibe')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete();

            $table->index('id_usuario');
            $table->index('id_recurso');
            $table->index('id_ejemplar');
            $table->index('id_estado_prestamo');
            $table->index('id_solicitud');
            $table->index('id_usuario_entrega');
            $table->index('id_usuario_recibe');
            $table->index('fecha_prestamo');
            $table->index('fecha_vencimiento');
            $table->index('fecha_devolucion');
            $table->index('activo');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_prestamos');
    }
};