<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TikRolSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'TIK')
            ->first();

        if (!$sistema) {
            return;
        }

        $roles = [
            [
                'nombre' => 'Super Administrador',
                'descripcion' => 'Acceso total al sistema de tickets',
                'activo' => 1,
            ],
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Administrador funcional del sistema de tickets',
                'activo' => 1,
            ],
            [
                'nombre' => 'Consulta',
                'descripcion' => 'Usuario solo lectura del sistema de tickets',
                'activo' => 1,
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('seg_roles')->updateOrInsert(
                [
                    'id_sistema' => $sistema->id_sistema,
                    'nombre' => $rol['nombre'],
                ],
                [
                    'descripcion' => $rol['descripcion'],
                    'activo' => $rol['activo'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}