<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('org_usuario_area', function (Blueprint $table) {
            $table->bigIncrements('id_usuario_area');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_area');
            $table->boolean('es_principal')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_usuario');
            $table->index('id_area');
            $table->unique(['id_usuario', 'id_area']);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('seg_usuarios');

            $table->foreign('id_area')
                ->references('id_area')
                ->on('org_areas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_usuario_area');
    }
};
