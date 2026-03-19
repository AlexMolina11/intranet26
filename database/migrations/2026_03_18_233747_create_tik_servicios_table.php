<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_servicios', function (Blueprint $table) {
            $table->bigIncrements('id_servicio');
            $table->unsignedBigInteger('id_tipo_servicio');
            $table->string('codigo', 80)->unique();
            $table->string('nombre', 180);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_tipo_servicio', 'fk_tik_servicio_tipo_servicio')
                ->references('id_tipo_servicio')
                ->on('tik_tipos_servicio')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index(['id_tipo_servicio', 'activo'], 'idx_tik_servicios_tipo_activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_servicios');
    }
};