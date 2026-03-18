<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('org_proyectos')->updateOrInsert(
            ['codigo' => 'NA'],
            [
                'nombre' => 'No aplica',
                'descripcion' => 'Proyecto base para asignaciones generales',
                'activo' => 1,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );
    }
}