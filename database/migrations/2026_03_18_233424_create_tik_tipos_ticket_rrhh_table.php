<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_tipos_ticket_rrhh', function (Blueprint $table) {
            $table->bigIncrements('id_tipo_ticket_rrhh');
            $table->unsignedBigInteger('id_tipo_ticket');
            $table->string('codigo', 80)->unique();
            $table->string('nombre', 180);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_tipo_ticket', 'fk_tik_tipo_ticket_rrhh_tipo_ticket')
                ->references('id_tipo_ticket')
                ->on('tik_tipos_ticket')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index(['id_tipo_ticket', 'activo'], 'idx_tik_tipo_ticket_rrhh_tipo_activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_tipos_ticket_rrhh');
    }
};