<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bib_politicas_prestamo', function (Blueprint $table) {
            $table->id('id_politica_prestamo');

            $table->unsignedBigInteger('id_tipo_recurso');

            $table->unsignedInteger('dias_prestamo')->default(0);
            $table->unsignedInteger('max_renovaciones')->default(0);
            $table->unsignedInteger('max_prestamos_usuario')->default(1);
            $table->decimal('multa_diaria', 10, 2)->default(0);

            $table->boolean('permite_reserva')->default(false);
            $table->boolean('requiere_aprobacion')->default(false);
            $table->boolean('permite_prestamo_externo')->default(true);

            $table->text('observaciones')->nullable();

            $table->unsignedInteger('orden')->default(1);
            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_tipo_recurso')
                ->references('id_tipo_recurso')
                ->on('bib_tipos_recurso')
                ->restrictOnDelete();

            $table->index('id_tipo_recurso');
            $table->index('orden');
            $table->index('activo');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bib_politicas_prestamo');
    }
};