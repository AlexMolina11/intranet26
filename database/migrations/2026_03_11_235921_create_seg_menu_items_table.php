<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_menu_items', function (Blueprint $table) {
            $table->bigIncrements('id_menu_item');
            $table->unsignedBigInteger('id_sistema');
            $table->unsignedBigInteger('id_menu');
            $table->unsignedBigInteger('id_menu_item_padre')->nullable();
            $table->string('nombre', 150);
            $table->string('ruta', 255);
            $table->string('icono', 100)->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('visible')->default(1)->index();
            $table->boolean('es_externo')->default(0);
            $table->boolean('abre_nueva_pestana')->default(0);
            $table->string('permiso_requerido', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_sistema');
            $table->index('id_menu');
            $table->index('id_menu_item_padre');
            $table->index('orden');
            $table->index('permiso_requerido');
            $table->index(['id_menu', 'orden']);
            $table->index(['id_menu_item_padre', 'orden']);

            $table->foreign('id_sistema')
                ->references('id_sistema')
                ->on('seg_sistemas');

            $table->foreign('id_menu')
                ->references('id_menu')
                ->on('seg_menus');

            $table->foreign('id_menu_item_padre')
                ->references('id_menu_item')
                ->on('seg_menu_items');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_menu_items');
    }
};
