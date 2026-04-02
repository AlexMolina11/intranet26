<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_tipos_recurso', function (Blueprint $table) {
            $table->id('id_tipo_recurso');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('dias_prestamo_default')->default(0);
            $table->unsignedInteger('renovaciones_default')->default(0);
            $table->decimal('multa_diaria_default', 10, 2)->default(0);
            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('orden');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_tipos_recurso');
    }
};