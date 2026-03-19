<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTicketSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tik_tipos_ticket')->upsert([
            [
                'codigo' => 'INFORMATICA',
                'nombre' => 'Informática',
                'descripcion' => 'Tickets relacionados con soporte informático y sistemas.',
                'id_area_responsable' => null,
                'orden' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'SERVICIOS_GENERALES',
                'nombre' => 'Servicios Generales y Mantenimiento',
                'descripcion' => 'Tickets relacionados con mantenimiento y servicios generales.',
                'id_area_responsable' => null,
                'orden' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'COMUNICACIONES',
                'nombre' => 'Comunicaciones',
                'descripcion' => 'Tickets relacionados con el área de comunicaciones.',
                'id_area_responsable' => null,
                'orden' => 3,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'TALENTO_HUMANO',
                'nombre' => 'Talento Humano',
                'descripcion' => 'Tickets especializados del área de Talento Humano.',
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