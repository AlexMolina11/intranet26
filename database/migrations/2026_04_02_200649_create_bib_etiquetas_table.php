<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_etiquetas', function (Blueprint $table) {
            $table->id('id_etiqueta');
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_etiquetas');
    }
};