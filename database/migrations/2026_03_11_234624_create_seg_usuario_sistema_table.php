<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_usuario_sistema', function (Blueprint $table) {
            $table->bigIncrements('id_usuario_sistema');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_sistema');
            $table->boolean('activo')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_usuario');
            $table->index('id_sistema');
            $table->index(['id_usuario', 'id_sistema']);

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
        Schema::dropIfExists('seg_usuario_sistema');
    }
};
