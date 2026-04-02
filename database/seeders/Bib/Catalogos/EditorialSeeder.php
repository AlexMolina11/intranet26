<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EditorialSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nombre' => 'Editorial Universitaria',
                'sigla' => 'EU',
                'sitio_web' => null,
                'descripcion' => 'Editorial institucional universitaria.',
                'activo' => true,
            ],
            [
                'nombre' => 'Penguin Random House',
                'sigla' => 'PRH',
                'sitio_web' => null,
                'descripcion' => 'Editorial internacional.',
                'activo' => true,
            ],
            [
                'nombre' => 'Alfaguara',
                'sigla' => null,
                'sitio_web' => null,
                'descripcion' => 'Editorial de obras literarias y de divulgación.',
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_editoriales')->updateOrInsert(
                ['nombre' => $item['nombre']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ])
            );
        }
    }
}