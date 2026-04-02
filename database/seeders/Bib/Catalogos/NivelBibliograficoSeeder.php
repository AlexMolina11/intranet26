<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelBibliograficoSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['codigo' => 'MON', 'nombre' => 'Monografía', 'descripcion' => 'Publicación unitaria o independiente.', 'orden' => 1, 'activo' => true],
            ['codigo' => 'SER', 'nombre' => 'Serie', 'descripcion' => 'Publicación seriada.', 'orden' => 2, 'activo' => true],
            ['codigo' => 'ANA', 'nombre' => 'Analítica', 'descripcion' => 'Parte o componente de otra obra.', 'orden' => 3, 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_niveles_bibliograficos')->updateOrInsert(
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