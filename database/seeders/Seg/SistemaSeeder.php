<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SistemaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('seg_sistemas')->updateOrInsert(
            ['codigo' => 'INTRANET'],
            [
                'codigo' => 'INTRANET',
                'nombre' => 'Intranet 2026',
                'slug' => 'intranet-2026',
                'descripcion' => 'Sistema base institucional',
                'activo' => 1,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }
}