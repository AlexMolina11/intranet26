<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'INTRANET')
            ->first();

        if (!$sistema) {
            return;
        }

        $menus = [
            [
                'nombre' => 'Seguridad',
                'icono' => 'fa-solid fa-user-shield',
                'orden' => 1,
                'visible' => 1,
            ],
            [
                'nombre' => 'Organización',
                'icono' => 'fa-solid fa-building',
                'orden' => 2,
                'visible' => 1,
            ],
        ];

        foreach ($menus as $menu) {
            DB::table('seg_menus')->updateOrInsert(
                [
                    'id_sistema' => $sistema->id_sistema,
                    'nombre' => $menu['nombre'],
                ],
                [
                    'icono' => $menu['icono'],
                    'orden' => $menu['orden'],
                    'visible' => $menu['visible'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}