<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_multas', function (Blueprint $table) {
            $table->id('id_multa');

            $table->unsignedBigInteger('id_prestamo');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_usuario_registra')->nullable();

            $table->date('fecha_multa');
            $table->unsignedInteger('dias_atraso')->default(0);
            $table->decimal('monto', 10, 2)->default(0);
            $table->decimal('monto_pagado', 10, 2)->default(0);

            $table->boolean('pagada')->default(false);
            $table->date('fecha_pago')->nullable();

            $table->text('motivo')->nullable();
            $table->text('observaciones')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_prestamo')
                ->references('id_prestamo')
                ->on('bib_prestamos')
                ->restrictOnDelete();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->restrictOnDelete();

            $table->foreign('id_usuario_registra')
                ->references('id_usuario')
                ->on('seg_usuarios')
                ->nullOnDelete();

            $table->index('id_prestamo');
            $table->index('id_usuario');
            $table->index('id_usuario_registra');
            $table->index('fecha_multa');
            $table->index('fecha_pago');
            $table->index('pagada');
            $table->index('activo');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_multas');
    }
};