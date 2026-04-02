<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_tipos_acceso', function (Blueprint $table) {
            $table->id('id_tipo_acceso');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->boolean('permite_prestamo')->default(true);
            $table->boolean('requiere_autorizacion')->default(false);
            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('orden');
            $table->index('activo');
            $table->index('permite_prestamo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_tipos_acceso');
    }
};