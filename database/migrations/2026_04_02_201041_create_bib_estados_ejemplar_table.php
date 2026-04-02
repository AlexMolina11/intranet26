<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_estados_ejemplar', function (Blueprint $table) {
            $table->id('id_estado_ejemplar');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('es_prestable')->default(true);
            $table->boolean('afecta_inventario')->default(true);
            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('orden');
            $table->index('activo');
            $table->index('es_prestable');
            $table->index('afecta_inventario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_estados_ejemplar');
    }
};