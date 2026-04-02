<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSolicitudBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'PENDIENTE',
                'nombre' => 'Pendiente',
                'descripcion' => 'Solicitud creada pendiente de atención.',
                'es_inicial' => true,
                'es_final' => false,
                'permite_aprobacion' => true,
                'permite_rechazo' => true,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'APROBADA',
                'nombre' => 'Aprobada',
                'descripcion' => 'Solicitud aprobada.',
                'es_inicial' => false,
                'es_final' => false,
                'permite_aprobacion' => false,
                'permite_rechazo' => false,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'RECHAZADA',
                'nombre' => 'Rechazada',
                'descripcion' => 'Solicitud rechazada.',
                'es_inicial' => false,
                'es_final' => true,
                'permite_aprobacion' => false,
                'permite_rechazo' => false,
                'orden' => 3,
                'activo' => true,
            ],
            [
                'codigo' => 'ATENDIDA',
                'nombre' => 'Atendida',
                'descripcion' => 'Solicitud ya atendida.',
                'es_inicial' => false,
                'es_final' => true,
                'permite_aprobacion' => false,
                'permite_rechazo' => false,
                'orden' => 4,
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_estados_solicitud')->updateOrInsert(
                ['codigo' => $item['codigo']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ])
            );
        }
    }
}