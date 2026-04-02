<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoEjemplarBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'ACTIVO',
                'nombre' => 'Activo',
                'descripcion' => 'Ejemplar habilitado para uso.',
                'es_prestable' => true,
                'afecta_inventario' => true,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'DANADO',
                'nombre' => 'Dañado',
                'descripcion' => 'Ejemplar dañado y no prestable.',
                'es_prestable' => false,
                'afecta_inventario' => true,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'EXTRAVIADO',
                'nombre' => 'Extraviado',
                'descripcion' => 'Ejemplar extraviado.',
                'es_prestable' => false,
                'afecta_inventario' => true,
                'orden' => 3,
                'activo' => true,
            ],
            [
                'codigo' => 'BAJA',
                'nombre' => 'Baja',
                'descripcion' => 'Ejemplar retirado del inventario activo.',
                'es_prestable' => false,
                'afecta_inventario' => false,
                'orden' => 4,
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_estados_ejemplar')->updateOrInsert(
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