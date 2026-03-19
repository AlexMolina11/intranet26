<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tik_incidencias')->upsert([
            [
                'codigo' => 'HARDWARE',
                'nombre' => 'Hardware',
                'descripcion' => 'Problemas relacionados con equipos o periféricos.',
                'id_area_responsable' => null,
                'orden' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'SOFTWARE',
                'nombre' => 'Software',
                'descripcion' => 'Problemas en aplicaciones o sistemas.',
                'id_area_responsable' => null,
                'orden' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'RED',
                'nombre' => 'Red',
                'descripcion' => 'Problemas de red o conectividad.',
                'id_area_responsable' => null,
                'orden' => 3,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'ACCESO',
                'nombre' => 'Acceso',
                'descripcion' => 'Problemas de acceso, credenciales o permisos.',
                'id_area_responsable' => null,
                'orden' => 4,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'CONFIGURACION',
                'nombre' => 'Configuración',
                'descripcion' => 'Ajustes o configuraciones necesarias.',
                'id_area_responsable' => null,
                'orden' => 5,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['codigo'], [
            'nombre',
            'descripcion',
            'id_area_responsable',
            'orden',
            'activo',
            'updated_at'
        ]);
    }
}