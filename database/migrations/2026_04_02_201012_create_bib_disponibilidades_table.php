<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_disponibilidades', function (Blueprint $table) {
            $table->id('id_disponibilidad');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('permite_reserva')->default(false);
            $table->boolean('permite_prestamo')->default(false);
            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('orden');
            $table->index('activo');
            $table->index('permite_reserva');
            $table->index('permite_prestamo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_disponibilidades');
    }
};