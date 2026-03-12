<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('org_proyectos', function (Blueprint $table) {
            $table->bigIncrements('id_proyecto');
            $table->string('codigo', 30)->nullable()->unique();
            $table->string('nombre', 150);
            $table->string('descripcion', 255)->nullable();
            $table->boolean('activo')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_proyectos');
    }
};
