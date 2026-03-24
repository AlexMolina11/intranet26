<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tik_tickets', function (Blueprint $table) {
            $table->dateTime('fecha_planificada')->nullable()->after('fecha_asignacion');
            $table->dateTime('fecha_inicio_ejecucion')->nullable()->after('fecha_planificada');
            $table->dateTime('fecha_fin_ejecucion')->nullable()->after('fecha_inicio_ejecucion');
        });
    }

    public function down(): void
    {
        Schema::table('tik_tickets', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_planificada',
                'fecha_inicio_ejecucion',
                'fecha_fin_ejecucion',
            ]);
        });
    }
};