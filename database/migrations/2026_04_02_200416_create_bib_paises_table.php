<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_paises', function (Blueprint $table) {
            $table->id('id_pais');
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 120);
            $table->text('descripcion')->nullable();
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
        Schema::dropIfExists('bib_paises');
    }
};