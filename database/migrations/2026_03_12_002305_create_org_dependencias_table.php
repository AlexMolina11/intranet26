<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('org_dependencias', function (Blueprint $table) {
            $table->bigIncrements('id_dependencia');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_jefe_usuario');
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->unique('id_usuario');
            $table->index('id_jefe_usuario');

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_jefe_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_dependencias');
    }
};
