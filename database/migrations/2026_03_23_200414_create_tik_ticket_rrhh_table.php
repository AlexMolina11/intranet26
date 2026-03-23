<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tik_ticket_rrhh', function (Blueprint $table) {
            $table->bigIncrements('id_ticket_rrhh');

            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_tipo_ticket_rrhh');

            $table->text('detalle')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ticket', 'fk_tik_ticket_rrhh_ticket')
                ->references('id_ticket')
                ->on('tik_tickets')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_tipo_ticket_rrhh', 'fk_tik_ticket_rrhh_tipo')
                ->references('id_tipo_ticket_rrhh')
                ->on('tik_tipos_ticket_rrhh')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->index('deleted_at', 'idx_tik_ticket_rrhh_deleted_at');
            $table->unique('id_ticket', 'uk_tik_ticket_rrhh_ticket');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tik_ticket_rrhh');
    }
};