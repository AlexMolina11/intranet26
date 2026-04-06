<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
            Schema::create('bib_ejemplares', function (Blueprint $table) {
        $table->id('id_ejemplar');

        $table->unsignedBigInteger('id_recurso');

        $table->string('codigo_inventario')->unique();
        $table->string('codigo_barras')->nullable();

        $table->unsignedBigInteger('id_estado_ejemplar');
        $table->unsignedBigInteger('id_disponibilidad');

        $table->string('ubicacion')->nullable();
        $table->string('condicion')->nullable();

        $table->date('fecha_adquisicion')->nullable();
        $table->decimal('costo', 10, 2)->nullable();

        $table->boolean('activo')->default(true);

        $table->timestamps();
        $table->softDeletes();

        // FK
        $table->foreign('id_recurso')->references('id_recurso')->on('bib_recursos');
        $table->foreign('id_estado_ejemplar')->references('id_estado_ejemplar')->on('bib_estados_ejemplar');
        $table->foreign('id_disponibilidad')->references('id_disponibilidad')->on('bib_disponibilidades');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bib_ejemplares');
    }
};
