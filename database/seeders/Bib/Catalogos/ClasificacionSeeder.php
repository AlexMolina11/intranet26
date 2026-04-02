<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['codigo' => 'LIT', 'nombre' => 'Literatura', 'descripcion' => 'Obras literarias y narrativa.', 'orden' => 1, 'activo' => true],
            ['codigo' => 'HIS', 'nombre' => 'Historia', 'descripcion' => 'Recursos históricos y documentales.', 'orden' => 2, 'activo' => true],
            ['codigo' => 'CIE', 'nombre' => 'Ciencias', 'descripcion' => 'Recursos científicos y técnicos.', 'orden' => 3, 'activo' => true],
            ['codigo' => 'EDU', 'nombre' => 'Educación', 'descripcion' => 'Material educativo y pedagógico.', 'orden' => 4, 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_clasificaciones')->updateOrInsert(
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