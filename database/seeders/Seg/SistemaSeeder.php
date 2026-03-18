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
                'nombre' => 'Intranet 2026',
                'slug' => 'intranet-2026',
                'descripcion' => 'Sistema base institucional',
                'icono' => 'fa-solid fa-building-columns',
                'url_base' => null,
                'orden' => 1,
                'activo' => 1,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );
    }
}