<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdiomaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['codigo' => 'ES', 'nombre' => 'Español', 'descripcion' => 'Idioma español.', 'orden' => 1, 'activo' => true],
            ['codigo' => 'EN', 'nombre' => 'Inglés', 'descripcion' => 'Idioma inglés.', 'orden' => 2, 'activo' => true],
            ['codigo' => 'FR', 'nombre' => 'Francés', 'descripcion' => 'Idioma francés.', 'orden' => 3, 'activo' => true],
            ['codigo' => 'PT', 'nombre' => 'Portugués', 'descripcion' => 'Idioma portugués.', 'orden' => 4, 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_idiomas')->updateOrInsert(
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