<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_sistemas', function (Blueprint $table) {
            $table->bigIncrements('id_sistema');
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 120);
            $table->string('slug', 120)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->string('icono', 100)->nullable();
            $table->string('url_base', 255)->nullable();
            $table->unsignedInteger('orden')->default(0)->index();
            $table->boolean('activo')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_sistemas');
    }
};
