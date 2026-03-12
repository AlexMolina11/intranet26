<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermisoSeeder extends Seeder
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

        $permisos = [
            ['codigo' => 'USUARIOS_VER', 'nombre' => 'Ver usuarios', 'descripcion' => 'Permite visualizar usuarios'],
            ['codigo' => 'USUARIOS_CREAR', 'nombre' => 'Crear usuarios', 'descripcion' => 'Permite crear usuarios'],
            ['codigo' => 'USUARIOS_EDITAR', 'nombre' => 'Editar usuarios', 'descripcion' => 'Permite editar usuarios'],
            ['codigo' => 'USUARIOS_ELIMINAR', 'nombre' => 'Eliminar usuarios', 'descripcion' => 'Permite eliminar usuarios'],

            ['codigo' => 'ROLES_VER', 'nombre' => 'Ver roles', 'descripcion' => 'Permite visualizar roles'],
            ['codigo' => 'ROLES_ASIGNAR', 'nombre' => 'Asignar roles', 'descripcion' => 'Permite asignar roles'],

            ['codigo' => 'PERMISOS_VER', 'nombre' => 'Ver permisos', 'descripcion' => 'Permite visualizar permisos'],
            ['codigo' => 'PERMISOS_ASIGNAR', 'nombre' => 'Asignar permisos', 'descripcion' => 'Permite asignar permisos'],

            ['codigo' => 'MENU_VER', 'nombre' => 'Ver menú', 'descripcion' => 'Permite visualizar menú'],
            ['codigo' => 'MENU_ADMIN', 'nombre' => 'Administrar menú', 'descripcion' => 'Permite administrar menú'],

            ['codigo' => 'ORG_VER', 'nombre' => 'Ver estructura organizacional', 'descripcion' => 'Permite visualizar estructura organizacional'],
            ['codigo' => 'ORG_ADMIN', 'nombre' => 'Administrar estructura organizacional', 'descripcion' => 'Permite administrar estructura organizacional'],
        ];

        foreach ($permisos as $permiso) {
            DB::table('seg_permisos')->updateOrInsert(
                [
                    'codigo' => $permiso['codigo'],
                ],
                [
                    'id_sistema' => $sistema->id_sistema,
                    'nombre' => $permiso['nombre'],
                    'descripcion' => $permiso['descripcion'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}