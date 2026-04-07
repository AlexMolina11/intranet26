<?php

namespace Database\Seeders\Bib;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BibRolPermisoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'BIB')
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

            'Administrador Biblioteca' => [
                'BIB_VER',
                'BIB_DASHBOARD_VER',
                'BIB_CATALOGOS_VER',
                'BIB_CATALOGOS_CREAR',
                'BIB_CATALOGOS_EDITAR',
                'BIB_RECURSOS_VER',
                'BIB_RECURSOS_CREAR',
                'BIB_RECURSOS_EDITAR',
                'BIB_EJEMPLARES_VER',
                'BIB_EJEMPLARES_CREAR',
                'BIB_EJEMPLARES_EDITAR',
                'BIB_SOLICITUDES_VER',
                'BIB_SOLICITUDES_CREAR',
                'BIB_SOLICITUDES_GESTIONAR',
                'BIB_PRESTAMOS_VER',
                'BIB_PRESTAMOS_CREAR',
                'BIB_PRESTAMOS_DEVOLVER',
                'BIB_MULTAS_VER',
                'BIB_MULTAS_GESTIONAR',
                'BIB_POLITICAS_VER',
                'BIB_POLITICAS_EDITAR',
                'BIB_CONSULTA_VER',
            ],

            'Bibliotecario' => [
                'BIB_VER',
                'BIB_DASHBOARD_VER',
                'BIB_CATALOGOS_VER',
                'BIB_RECURSOS_VER',
                'BIB_RECURSOS_CREAR',
                'BIB_RECURSOS_EDITAR',
                'BIB_EJEMPLARES_VER',
                'BIB_EJEMPLARES_CREAR',
                'BIB_EJEMPLARES_EDITAR',
                'BIB_SOLICITUDES_VER',
                'BIB_SOLICITUDES_CREAR',
                'BIB_SOLICITUDES_GESTIONAR',
                'BIB_PRESTAMOS_VER',
                'BIB_PRESTAMOS_CREAR',
                'BIB_PRESTAMOS_DEVOLVER',
                'BIB_MULTAS_VER',
                'BIB_POLITICAS_VER',
                'BIB_CONSULTA_VER',
            ],

            'Consulta Biblioteca' => [
                'BIB_VER',
                'BIB_DASHBOARD_VER',
                'BIB_CATALOGOS_VER',
                'BIB_RECURSOS_VER',
                'BIB_EJEMPLARES_VER',
                'BIB_SOLICITUDES_VER',
                'BIB_PRESTAMOS_VER',
                'BIB_MULTAS_VER',
                'BIB_POLITICAS_VER',
                'BIB_CONSULTA_VER',
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