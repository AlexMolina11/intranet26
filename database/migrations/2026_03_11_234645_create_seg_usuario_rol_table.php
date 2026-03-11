<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_usuario_rol', function (Blueprint $table) {
            $table->bigIncrements('id_usuario_rol');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_rol');
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_usuario');
            $table->index('id_rol');
            $table->index(['id_usuario', 'id_rol']);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_rol')
                ->references('id_rol')
                ->on('seg_roles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_usuario_rol');
    }
};
