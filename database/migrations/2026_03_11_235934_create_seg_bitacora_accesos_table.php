<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_bitacora_accesos', function (Blueprint $table) {
            $table->bigIncrements('id_bitacora_acceso');
            $table->unsignedBigInteger('id_usuario');
            $table->dateTime('fecha_hora_acceso')->index();
            $table->dateTime('fecha_hora_salida')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('navegador', 255)->nullable();
            $table->string('plataforma', 255)->nullable();
            $table->string('resultado', 50)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_usuario');
            $table->index(['id_usuario', 'fecha_hora_acceso']);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_bitacora_accesos');
    }
};
