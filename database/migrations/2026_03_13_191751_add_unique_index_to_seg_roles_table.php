<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seg_roles', function (Blueprint $table) {
            $table->unique(['id_sistema', 'nombre'], 'seg_roles_id_sistema_nombre_unique');
        });
    }

    public function down(): void
    {
        Schema::table('seg_roles', function (Blueprint $table) {
            $table->dropUnique('seg_roles_id_sistema_nombre_unique');
        });
    }
};