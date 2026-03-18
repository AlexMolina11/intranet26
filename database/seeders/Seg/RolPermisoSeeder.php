<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolPermisoSeeder extends Seeder
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

        $rolSuperAdmin = DB::table('seg_roles')
            ->where('id_sistema', $sistema->id_sistema)
            ->where('nombre', 'Super Administrador')
            ->first();

        $rolAdministrador = DB::table('seg_roles')
            ->where('id_sistema', $sistema->id_sistema)
            ->where('nombre', 'Administrador')
            ->first();

        $rolConsulta = DB::table('seg_roles')
            ->where('id_sistema', $sistema->id_sistema)
            ->where('nombre', 'Consulta')
            ->first();

        $permisos = DB::table('seg_permisos')
            ->where('id_sistema', $sistema->id_sistema)
            ->get();

        if ($rolSuperAdmin) {
            foreach ($permisos as $permiso) {
                DB::table('seg_rol_permiso')->updateOrInsert(
                    [
                        'id_rol' => $rolSuperAdmin->id_rol,
                        'id_permiso' => $permiso->id_permiso,
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }

        if ($rolAdministrador) {
            $codigosAdmin = [
                'DASHBOARD_VER',
                'USUARIOS_VER', 'USUARIOS_CREAR', 'USUARIOS_EDITAR',
                'SISTEMAS_VER',
                'ROLES_VER',
                'PERMISOS_VER',
                'MENUS_VER', 'MENU_ITEMS_VER',
                'ORG_DEPARTAMENTOS_VER', 'ORG_DEPARTAMENTOS_CREAR', 'ORG_DEPARTAMENTOS_EDITAR',
                'ORG_PROYECTOS_VER', 'ORG_PROYECTOS_CREAR', 'ORG_PROYECTOS_EDITAR',
                'ORG_AREAS_VER', 'ORG_AREAS_CREAR', 'ORG_AREAS_EDITAR',
                'ORG_USUARIO_AREA_VER', 'ORG_USUARIO_AREA_ASIGNAR',
            ];

            $permisosAdmin = DB::table('seg_permisos')
                ->where('id_sistema', $sistema->id_sistema)
                ->whereIn('codigo', $codigosAdmin)
                ->get();

            foreach ($permisosAdmin as $permiso) {
                DB::table('seg_rol_permiso')->updateOrInsert(
                    [
                        'id_rol' => $rolAdministrador->id_rol,
                        'id_permiso' => $permiso->id_permiso,
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }

        if ($rolConsulta) {
            $codigosConsulta = [
                'DASHBOARD_VER',
                'USUARIOS_VER',
                'SISTEMAS_VER',
                'ROLES_VER',
                'PERMISOS_VER',
                'MENUS_VER',
                'MENU_ITEMS_VER',
                'ORG_DEPARTAMENTOS_VER',
                'ORG_PROYECTOS_VER',
                'ORG_AREAS_VER',
                'ORG_USUARIO_AREA_VER',
            ];

            $permisosConsulta = DB::table('seg_permisos')
                ->where('id_sistema', $sistema->id_sistema)
                ->whereIn('codigo', $codigosConsulta)
                ->get();

            foreach ($permisosConsulta as $permiso) {
                DB::table('seg_rol_permiso')->updateOrInsert(
                    [
                        'id_rol' => $rolConsulta->id_rol,
                        'id_permiso' => $permiso->id_permiso,
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}