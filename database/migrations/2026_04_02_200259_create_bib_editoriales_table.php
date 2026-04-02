<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_editoriales', function (Blueprint $table) {
            $table->id('id_editorial');
            $table->string('nombre', 150);
            $table->string('sigla', 50)->nullable();
            $table->string('sitio_web', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_editoriales');
    }
};