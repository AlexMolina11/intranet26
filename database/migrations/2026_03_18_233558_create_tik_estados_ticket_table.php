<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_estados_ticket', function (Blueprint $table) {
            $table->bigIncrements('id_estado_ticket');
            $table->string('codigo', 60)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->string('color', 20)->nullable();
            $table->unsignedBigInteger('id_estado_siguiente')->nullable();
            $table->boolean('es_inicial')->default(false);
            $table->boolean('es_final')->default(false);
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_estado_siguiente', 'fk_tik_estado_ticket_siguiente')
                ->references('id_estado_ticket')
                ->on('tik_estados_ticket')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->index(['activo', 'orden'], 'idx_tik_estados_ticket_activo_orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_estados_ticket');
    }
};