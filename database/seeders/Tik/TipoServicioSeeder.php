<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tik_tipos_servicio')->upsert([
            [
                'codigo' => 'INFORMATICA',
                'nombre' => 'Informática',
                'descripcion' => 'Servicios de soporte del área informática.',
                'id_area_responsable' => null,
                'orden' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'MANTENIMIENTO',
                'nombre' => 'Mantenimiento',
                'descripcion' => 'Servicios de mantenimiento y atención general.',
                'id_area_responsable' => null,
                'orden' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'COMUNICACIONES',
                'nombre' => 'Comunicaciones',
                'descripcion' => 'Servicios del área de comunicaciones.',
                'id_area_responsable' => null,
                'orden' => 3,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'TALENTO_HUMANO',
                'nombre' => 'Talento Humano',
                'descripcion' => 'Servicios administrativos y de RRHH.',
                'id_area_responsable' => null,
                'orden' => 4,
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