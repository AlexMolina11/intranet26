<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_roles', function (Blueprint $table) {
            $table->bigIncrements('id_rol');
            $table->unsignedBigInteger('id_sistema');
            $table->string('nombre', 120);
            $table->string('descripcion', 255)->nullable();
            $table->boolean('activo')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_sistema');
            $table->index(['id_sistema', 'nombre']);

            $table->foreign('id_sistema')
                ->references('id_sistema')
                ->on('seg_sistemas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_roles');
    }
};
