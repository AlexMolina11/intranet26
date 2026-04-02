<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['codigo' => 'SV', 'nombre' => 'El Salvador', 'descripcion' => 'País de Centroamérica.', 'orden' => 1, 'activo' => true],
            ['codigo' => 'MX', 'nombre' => 'México', 'descripcion' => 'País de Norteamérica.', 'orden' => 2, 'activo' => true],
            ['codigo' => 'CO', 'nombre' => 'Colombia', 'descripcion' => 'País de Sudamérica.', 'orden' => 3, 'activo' => true],
            ['codigo' => 'ES', 'nombre' => 'España', 'descripcion' => 'País europeo.', 'orden' => 4, 'activo' => true],
            ['codigo' => 'FR', 'nombre' => 'Francia', 'descripcion' => 'País europeo.', 'orden' => 5, 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_paises')->updateOrInsert(
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