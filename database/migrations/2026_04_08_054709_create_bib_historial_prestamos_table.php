<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_historial_prestamos', function (Blueprint $table) {
            $table->id('id_historial_prestamo');

            $table->unsignedBigInteger('id_prestamo');
            $table->unsignedBigInteger('id_estado_prestamo')->nullable();
            $table->unsignedBigInteger('id_usuario_accion')->nullable();

            $table->string('tipo_movimiento', 50);
            $table->date('fecha_movimiento');

            $table->date('fecha_prestamo')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_devolucion')->nullable();

            $table->unsignedInteger('dias_autorizados')->default(0);
            $table->unsignedInteger('renovaciones_usadas')->default(0);
            $table->unsignedInteger('renovaciones_maximas')->default(0);

            $table->decimal('multa_diaria', 10, 2)->default(0);
            $table->decimal('multa_acumulada', 10, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->foreign('id_prestamo')
                ->references('id_prestamo')
                ->on('bib_prestamos')
                ->cascadeOnDelete();

            $table->foreign('id_estado_prestamo')
                ->references('id_estado_prestamo')
                ->on('bib_estados_prestamo')
                ->nullOnDelete();

            $table->foreign('id_usuario_accion')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete();

            $table->index('id_prestamo');
            $table->index('id_estado_prestamo');
            $table->index('id_usuario_accion');
            $table->index('tipo_movimiento');
            $table->index('fecha_movimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_historial_prestamos');
    }
};