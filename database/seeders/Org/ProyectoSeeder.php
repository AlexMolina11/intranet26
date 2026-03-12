<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        DB::table('org_proyectos')->insert([
            [
                'codigo' => 'INST',
                'nombre' => 'Institucional',
                'descripcion' => 'Proyecto institucional general',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'codigo' => 'ADM',
                'nombre' => 'Administrativo',
                'descripcion' => 'Proyecto administrativo',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'codigo' => 'SOP',
                'nombre' => 'Soporte Interno',
                'descripcion' => 'Proyecto de soporte interno',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'codigo' => 'TD',
                'nombre' => 'Transformación Digital',
                'descripcion' => 'Proyecto de transformación digital',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
        ]);
    }
}