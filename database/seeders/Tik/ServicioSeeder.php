<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = DB::table('tik_tipos_servicio')
            ->pluck('id_tipo_servicio', 'codigo');

        if ($tipos->isEmpty()) {
            return;
        }

        $servicios = [
            [
                'tipo' => 'INFORMATICA',
                'codigo' => 'SOPORTE_TECNICO',
                'nombre' => 'Soporte técnico',
                'descripcion' => 'Atención general de soporte técnico.',
                'orden' => 1,
            ],
            [
                'tipo' => 'INFORMATICA',
                'codigo' => 'SISTEMAS',
                'nombre' => 'Sistemas',
                'descripcion' => 'Atención de sistemas internos.',
                'orden' => 2,
            ],
            [
                'tipo' => 'MANTENIMIENTO',
                'codigo' => 'MANTENIMIENTO_GENERAL',
                'nombre' => 'Mantenimiento general',
                'descripcion' => 'Atención de infraestructura y mantenimiento.',
                'orden' => 3,
            ],
            [
                'tipo' => 'COMUNICACIONES',
                'codigo' => 'DISENO_COMUNICACION',
                'nombre' => 'Diseño y comunicación',
                'descripcion' => 'Atención de materiales y requerimientos de comunicación.',
                'orden' => 4,
            ],
            [
                'tipo' => 'TALENTO_HUMANO',
                'codigo' => 'GESTION_RRHH',
                'nombre' => 'Gestión RRHH',
                'descripcion' => 'Atención administrativa de Talento Humano.',
                'orden' => 5,
            ],
        ];

        foreach ($servicios as $servicio) {
            if (!isset($tipos[$servicio['tipo']])) {
                continue;
            }

            DB::table('tik_servicios')->updateOrInsert(
                ['codigo' => $servicio['codigo']],
                [
                    'id_tipo_servicio' => $tipos[$servicio['tipo']],
                    'nombre' => $servicio['nombre'],
                    'descripcion' => $servicio['descripcion'],
                    'orden' => $servicio['orden'],
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}