<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolSeeder extends Seeder
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

        $roles = [
            [
                'id_sistema' => $sistema->id_sistema,
                'nombre' => 'Super Administrador',
                'descripcion' => 'Acceso total al sistema',
                'activo' => 1,
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'nombre' => 'Administrador',
                'descripcion' => 'Administrador funcional del sistema',
                'activo' => 1,
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'nombre' => 'Consulta',
                'descripcion' => 'Usuario solo lectura',
                'activo' => 1,
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('seg_roles')->updateOrInsert(
                [
                    'id_sistema' => $rol['id_sistema'],
                    'nombre' => $rol['nombre'],
                ],
                [
                    'descripcion' => $rol['descripcion'],
                    'activo' => $rol['activo'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}