<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('org_areas', function (Blueprint $table) {
            $table->bigIncrements('id_area');
            $table->unsignedBigInteger('id_departamento');
            $table->unsignedBigInteger('id_proyecto');
            $table->string('nombre', 150)->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->boolean('activo')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_departamento');
            $table->index('id_proyecto');
            $table->index(['id_departamento', 'id_proyecto']);

            $table->foreign('id_departamento')
                ->references('id_departamento')
                ->on('org_departamentos');

            $table->foreign('id_proyecto')
                ->references('id_proyecto')
                ->on('org_proyectos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_areas');
    }
};
