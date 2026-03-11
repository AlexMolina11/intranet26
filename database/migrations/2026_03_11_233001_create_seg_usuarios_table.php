<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seg_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id_usuario');
            $table->string('nombres', 150);
            $table->string('apellidos', 150);
            $table->string('correo', 150)->unique();
            $table->string('nombre_usuario', 100)->unique();
            $table->string('clave', 255);
            $table->boolean('activo')->default(1)->index();
            $table->dateTime('ultimo_acceso')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seg_usuarios');
    }
};
