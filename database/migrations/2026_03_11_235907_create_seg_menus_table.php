<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_menus', function (Blueprint $table) {
            $table->bigIncrements('id_menu');
            $table->unsignedBigInteger('id_sistema');
            $table->string('nombre', 120);
            $table->string('icono', 100)->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('visible')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
            $table->index('id_sistema');
            $table->index('orden');
            $table->index(['id_sistema', 'orden']);

            $table->foreign('id_sistema')
                ->references('id_sistema')
                ->on('seg_sistemas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_menus');
    }
};
