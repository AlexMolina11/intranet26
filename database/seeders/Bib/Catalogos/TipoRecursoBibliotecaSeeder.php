<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoRecursoBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'LIBRO',
                'nombre' => 'Libro',
                'descripcion' => 'Libro físico o bibliográfico general.',
                'dias_prestamo_default' => 8,
                'renovaciones_default' => 1,
                'multa_diaria_default' => 0.25,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'REVISTA',
                'nombre' => 'Revista',
                'descripcion' => 'Publicación periódica.',
                'dias_prestamo_default' => 3,
                'renovaciones_default' => 0,
                'multa_diaria_default' => 0.25,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'TESIS',
                'nombre' => 'Tesis',
                'descripcion' => 'Trabajo académico de grado.',
                'dias_prestamo_default' => 5,
                'renovaciones_default' => 0,
                'multa_diaria_default' => 0.50,
                'orden' => 3,
                'activo' => true,
            ],
            [
                'codigo' => 'DIGITAL',
                'nombre' => 'Recurso digital',
                'descripcion' => 'Material digital o electrónico.',
                'dias_prestamo_default' => 0,
                'renovaciones_default' => 0,
                'multa_diaria_default' => 0.00,
                'orden' => 4,
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_tipos_recurso')->updateOrInsert(
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