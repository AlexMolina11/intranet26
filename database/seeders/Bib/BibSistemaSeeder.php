<?php

namespace Database\Seeders\Bib;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BibSistemaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seg_sistemas')->updateOrInsert(
            ['codigo' => 'BIB'],
            [
                'nombre' => 'Biblioteca',
                'slug' => 'biblioteca',
                'descripcion' => 'Módulo de gestión bibliográfica, ejemplares, préstamos y multas.',
                'orden' => 5,
                'activo' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}