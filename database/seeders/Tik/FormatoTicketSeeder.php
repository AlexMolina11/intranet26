<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatoTicketSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tik_formatos_ticket')->upsert([
            [
                'codigo' => 'DIGITAL',
                'nombre' => 'Digital',
                'descripcion' => 'Formato digital del ticket.',
                'orden' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'IMPRESO',
                'nombre' => 'Impreso',
                'descripcion' => 'Formato físico o impreso del ticket.',
                'orden' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['codigo'], ['nombre', 'descripcion', 'orden', 'activo', 'updated_at']);
    }
}