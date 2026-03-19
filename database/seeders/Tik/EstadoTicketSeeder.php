<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoTicketSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            [
                'codigo' => 'PENDIENTE_ASIGNAR',
                'nombre' => 'Pendiente de Asignar',
                'descripcion' => 'Ticket registrado y pendiente de asignación.',
                'color' => '#64748b',
                'es_inicial' => true,
                'es_final' => false,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'ASIGNADO',
                'nombre' => 'Asignado',
                'descripcion' => 'Ticket asignado a un responsable.',
                'color' => '#2563eb',
                'es_inicial' => false,
                'es_final' => false,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'PLANIFICADO',
                'nombre' => 'Planificado',
                'descripcion' => 'Ticket con planificación definida.',
                'color' => '#7c3aed',
                'es_inicial' => false,
                'es_final' => false,
                'orden' => 3,
                'activo' => true,
            ],
            [
                'codigo' => 'EN_PROCESO',
                'nombre' => 'En Proceso',
                'descripcion' => 'Ticket en ejecución.',
                'color' => '#d97706',
                'es_inicial' => false,
                'es_final' => false,
                'orden' => 4,
                'activo' => true,
            ],
            [
                'codigo' => 'FINALIZADO',
                'nombre' => 'Finalizado',
                'descripcion' => 'Ticket finalizado.',
                'color' => '#16a34a',
                'es_inicial' => false,
                'es_final' => true,
                'orden' => 5,
                'activo' => true,
            ],
            [
                'codigo' => 'NO_APLICA',
                'nombre' => 'No Aplica',
                'descripcion' => 'El ticket no aplica o no procede.',
                'color' => '#475569',
                'es_inicial' => false,
                'es_final' => true,
                'orden' => 6,
                'activo' => true,
            ],
            [
                'codigo' => 'CANCELADO',
                'nombre' => 'Cancelado',
                'descripcion' => 'Ticket cancelado.',
                'color' => '#b91c1c',
                'es_inicial' => false,
                'es_final' => true,
                'orden' => 7,
                'activo' => true,
            ],
            [
                'codigo' => 'PROYECTO',
                'nombre' => 'Proyecto',
                'descripcion' => 'Ticket gestionado como proyecto.',
                'color' => '#0f766e',
                'es_inicial' => false,
                'es_final' => false,
                'orden' => 8,
                'activo' => true,
            ],
            [
                'codigo' => 'PROYECTO_FINALIZADO',
                'nombre' => 'Proyecto Finalizado',
                'descripcion' => 'Proyecto asociado al ticket finalizado.',
                'color' => '#15803d',
                'es_inicial' => false,
                'es_final' => true,
                'orden' => 9,
                'activo' => true,
            ],
        ];

        foreach ($registros as $registro) {
            DB::table('tik_estados_ticket')->updateOrInsert(
                ['codigo' => $registro['codigo']],
                array_merge($registro, [
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }

        $mapa = DB::table('tik_estados_ticket')
            ->pluck('id_estado_ticket', 'codigo');

        $siguientes = [
            'PENDIENTE_ASIGNAR' => 'ASIGNADO',
            'ASIGNADO' => 'PLANIFICADO',
            'PLANIFICADO' => 'EN_PROCESO',
            'EN_PROCESO' => 'FINALIZADO',
            'PROYECTO' => 'PROYECTO_FINALIZADO',
        ];

        foreach ($siguientes as $codigoActual => $codigoSiguiente) {
            DB::table('tik_estados_ticket')
                ->where('codigo', $codigoActual)
                ->update([
                    'id_estado_siguiente' => $mapa[$codigoSiguiente] ?? null,
                    'updated_at' => now(),
                ]);
        }
    }
}