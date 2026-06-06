<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_notificaciones', function (Blueprint $table) {
            $table->id('id_notificacion');

            $table->foreignId('id_usuario')
                ->constrained('seg_usuarios', 'id_usuario');

            $table->foreignId('id_prestamo')
                ->nullable()
                ->constrained('bib_prestamos', 'id_prestamo');

            $table->string('tipo', 50);
            $table->string('titulo', 150);
            $table->text('mensaje');

            $table->date('fecha_notificacion');
            $table->boolean('leida')->default(false);
            $table->timestamp('fecha_lectura')->nullable();

            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id_usuario', 'leida']);
            $table->index(['tipo', 'fecha_notificacion']);
            $table->index(['id_prestamo', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_notificaciones');
    }
};