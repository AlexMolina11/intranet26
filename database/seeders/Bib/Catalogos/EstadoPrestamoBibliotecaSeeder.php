<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoPrestamoBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'ENTREGADO',
                'nombre' => 'Entregado',
                'descripcion' => 'Préstamo entregado al usuario.',
                'es_inicial' => true,
                'es_final' => false,
                'genera_multa' => false,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'VENCIDO',
                'nombre' => 'Vencido',
                'descripcion' => 'Préstamo con fecha vencida.',
                'es_inicial' => false,
                'es_final' => false,
                'genera_multa' => true,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'DEVUELTO',
                'nombre' => 'Devuelto',
                'descripcion' => 'Préstamo finalizado por devolución.',
                'es_inicial' => false,
                'es_final' => true,
                'genera_multa' => false,
                'orden' => 3,
                'activo' => true,
            ],
            [
                'codigo' => 'CANCELADO',
                'nombre' => 'Cancelado',
                'descripcion' => 'Préstamo cancelado.',
                'es_inicial' => false,
                'es_final' => true,
                'genera_multa' => false,
                'orden' => 4,
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_estados_prestamo')->updateOrInsert(
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