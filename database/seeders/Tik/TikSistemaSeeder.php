<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TikSistemaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seg_sistemas')->updateOrInsert(
            ['codigo' => 'TIK'],
            [
                'nombre' => 'Tickets y Soporte',
                'slug' => 'tickets-soporte',
                'descripcion' => 'Módulo de tickets, seguimiento y soporte.',
                'orden' => 4,
                'activo' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}