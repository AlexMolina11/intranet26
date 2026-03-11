<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_permisos', function (Blueprint $table) {
            $table->bigIncrements('id_permiso');
            $table->unsignedBigInteger('id_sistema');
            $table->string('codigo', 150)->unique();
            $table->string('nombre', 150);
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_sistema');

            $table->foreign('id_sistema')
                ->references('id_sistema')
                ->on('seg_sistemas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_permisos');
    }
};
