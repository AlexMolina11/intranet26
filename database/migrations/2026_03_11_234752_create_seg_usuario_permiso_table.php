<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_usuario_permiso', function (Blueprint $table) {
            $table->bigIncrements('id_usuario_permiso');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_permiso');
            $table->boolean('permitido')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_usuario');
            $table->index('id_permiso');
            $table->index(['id_usuario', 'id_permiso']);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_permiso')
                ->references('id_permiso')
                ->on('seg_permisos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_usuario_permiso');
    }
};
