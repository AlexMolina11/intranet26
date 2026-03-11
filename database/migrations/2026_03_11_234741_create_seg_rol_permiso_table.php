<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_rol_permiso', function (Blueprint $table) {
            $table->bigIncrements('id_rol_permiso');
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_permiso');
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_rol');
            $table->index('id_permiso');
            $table->index(['id_rol', 'id_permiso']);

            $table->foreign('id_rol')
                ->references('id_rol')
                ->on('seg_roles');

            $table->foreign('id_permiso')
                ->references('id_permiso')
                ->on('seg_permisos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_rol_permiso');
    }
};
