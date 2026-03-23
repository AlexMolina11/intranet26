<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TikRolPermisoSeeder extends Seeder
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

        $todosLosPermisos = DB::table('seg_permisos')
            ->where('id_sistema', $sistema->id_sistema)
            ->get();

        if ($rolSuperAdmin) {
            foreach ($todosLosPermisos as $permiso) {
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
                'TIK_VER',
                'TIK_PANEL_ADMIN_VER',
                'TIK_TICKETS_VER',
                'TIK_TICKETS_CREAR',
                'TIK_TICKETS_DETALLE',
                'TIK_TICKETS_ADMIN_VER',
                'TIK_TICKETS_ASIGNAR',
                'TIK_TICKETS_CLASIFICAR',
                'TIK_TICKETS_GESTIONAR',
                'TIK_TICKETS_PLANIFICAR',
                'TIK_TICKETS_EJECUTAR',
                'TIK_TICKETS_CERRAR',
                'TIK_SOPORTES_VER',
                'TIK_SOPORTES_CREAR',
                'TIK_SOPORTES_EVALUAR',
                'TIK_CATALOGOS_VER',
                'TIK_CATALOGOS_CREAR',
                'TIK_CATALOGOS_EDITAR',
                'TIK_FLUJOS_VER',
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
                'TIK_VER',
                'TIK_TICKETS_VER',
                'TIK_TICKETS_CREAR',
                'TIK_TICKETS_DETALLE',
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