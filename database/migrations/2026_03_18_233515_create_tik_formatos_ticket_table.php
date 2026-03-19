<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_formatos_ticket', function (Blueprint $table) {
            $table->bigIncrements('id_formato_ticket');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['activo', 'orden'], 'idx_tik_formatos_ticket_activo_orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_formatos_ticket');
    }
};