<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['codigo' => 'NOV', 'nombre' => 'Novela', 'descripcion' => 'Narrativa extensa.', 'orden' => 1, 'activo' => true],
            ['codigo' => 'ENS', 'nombre' => 'Ensayo', 'descripcion' => 'Texto reflexivo o argumentativo.', 'orden' => 2, 'activo' => true],
            ['codigo' => 'POE', 'nombre' => 'Poesía', 'descripcion' => 'Composición poética.', 'orden' => 3, 'activo' => true],
            ['codigo' => 'BIO', 'nombre' => 'Biografía', 'descripcion' => 'Obras biográficas.', 'orden' => 4, 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_generos')->updateOrInsert(
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