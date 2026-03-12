<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_bitacora_acciones', function (Blueprint $table) {
            $table->bigIncrements('id_bitacora_accion');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_sistema')->nullable();
            $table->string('modulo', 100)->index();
            $table->string('tabla_afectada', 100);
            $table->unsignedBigInteger('id_registro_afectado')->nullable();
            $table->string('accion', 50)->index();
            $table->text('descripcion')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_usuario');
            $table->index('id_sistema');
            $table->index('tabla_afectada');
            $table->index('id_registro_afectado');
            $table->index(['id_usuario', 'created_at']);
            $table->index(['id_sistema', 'modulo']);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_sistema')
                ->references('id_sistema')
                ->on('seg_sistemas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_bitacora_acciones');
    }
};
