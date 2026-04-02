<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisponibilidadBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'DISPONIBLE',
                'nombre' => 'Disponible',
                'descripcion' => 'Ejemplar disponible para préstamo o consulta.',
                'permite_reserva' => true,
                'permite_prestamo' => true,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'PRESTADO',
                'nombre' => 'Prestado',
                'descripcion' => 'Ejemplar actualmente prestado.',
                'permite_reserva' => true,
                'permite_prestamo' => false,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'RESERVADO',
                'nombre' => 'Reservado',
                'descripcion' => 'Ejemplar reservado para un usuario.',
                'permite_reserva' => false,
                'permite_prestamo' => false,
                'orden' => 3,
                'activo' => true,
            ],
            [
                'codigo' => 'NO_DISPONIBLE',
                'nombre' => 'No disponible',
                'descripcion' => 'Ejemplar temporalmente no disponible.',
                'permite_reserva' => false,
                'permite_prestamo' => false,
                'orden' => 4,
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_disponibilidades')->updateOrInsert(
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