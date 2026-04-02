<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutorSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nombre' => 'Gabriel',
                'apellido' => 'García Márquez',
                'nombre_completo' => 'Gabriel García Márquez',
                'seudonimo' => null,
                'fecha_nacimiento' => '1927-03-06',
                'fecha_fallecimiento' => '2014-04-17',
                'biografia' => 'Escritor, guionista y periodista colombiano.',
                'activo' => true,
            ],
            [
                'nombre' => 'Miguel',
                'apellido' => 'de Cervantes',
                'nombre_completo' => 'Miguel de Cervantes',
                'seudonimo' => null,
                'fecha_nacimiento' => '1547-09-29',
                'fecha_fallecimiento' => '1616-04-22',
                'biografia' => 'Novelista, poeta, dramaturgo y soldado español.',
                'activo' => true,
            ],
            [
                'nombre' => 'Antoine',
                'apellido' => 'de Saint-Exupéry',
                'nombre_completo' => 'Antoine de Saint-Exupéry',
                'seudonimo' => null,
                'fecha_nacimiento' => '1900-06-29',
                'fecha_fallecimiento' => '1944-07-31',
                'biografia' => 'Escritor y aviador francés.',
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_autores')->updateOrInsert(
                ['nombre_completo' => $item['nombre_completo']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ])
            );
        }
    }
}