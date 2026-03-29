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

        $roles = DB::table('seg_roles')
            ->where('id_sistema', $sistema->id_sistema)
            ->get()
            ->keyBy('nombre');

        $permisos = DB::table('seg_permisos')
            ->where('id_sistema', $sistema->id_sistema)
            ->get()
            ->keyBy('codigo');

        $mapa = [
            'Super Administrador' => array_keys($permisos->toArray()),

            'Administrador Tickets' => [
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
                'TIK_FLUJOS_CREAR',
                'TIK_FLUJOS_EDITAR',
            ],

            'Gestor Tickets' => [
                'TIK_VER',
                'TIK_PANEL_GESTOR_VER',
                'TIK_TICKETS_DETALLE',
                'TIK_TICKETS_GESTOR_VER',
                'TIK_TICKETS_GESTIONAR',
                'TIK_TICKETS_PLANIFICAR',
                'TIK_TICKETS_EJECUTAR',
                'TIK_TICKETS_CERRAR',
                'TIK_SOPORTES_VER',
                'TIK_SOPORTES_CREAR',
            ],

            'Solicitante' => [
                'TIK_VER',
                'TIK_TICKETS_VER',
                'TIK_TICKETS_CREAR',
                'TIK_TICKETS_DETALLE',
            ],

            'Consulta Tickets' => [
                'TIK_VER',
                'TIK_TICKETS_DETALLE',
                'TIK_TICKETS_ADMIN_VER',
                'TIK_CATALOGOS_VER',
                'TIK_FLUJOS_VER',
                'TIK_SOPORTES_VER',
            ],
        ];

        foreach ($mapa as $nombreRol => $codigosPermiso) {
            $rol = $roles->get($nombreRol);

            if (!$rol) {
                continue;
            }

            foreach ($codigosPermiso as $codigoPermiso) {
                $permiso = $permisos->get($codigoPermiso);

                if (!$permiso) {
                    continue;
                }

                DB::table('seg_rol_permiso')->updateOrInsert(
                    [
                        'id_rol' => $rol->id_rol,
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