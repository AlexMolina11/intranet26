<?php

namespace Database\Seeders\Seg;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosPruebaSeeder extends Seeder
{
    private string $clave = 'Admin2026*';

    public function run(): void
    {
        $now = Carbon::now();

        $usuarios = [
            [
                'nombres' => 'Administrador',
                'apellidos' => 'General',
                'correo' => 'admin@intranet.local',
                'nombre_usuario' => 'admin',
                'sistemas' => [
                    'INTRANET' => 'Super Administrador',
                    'TIK' => 'Super Administrador',
                    'BIB' => 'Super Administrador',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Administrador',
                'apellidos' => 'Biblioteca',
                'correo' => 'bib.admin@intranet.local',
                'nombre_usuario' => 'bib.admin',
                'sistemas' => [
                    'BIB' => 'Administrador Biblioteca',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Operador',
                'apellidos' => 'Biblioteca',
                'correo' => 'bib.operador@intranet.local',
                'nombre_usuario' => 'bib.operador',
                'sistemas' => [
                    'BIB' => 'Bibliotecario',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Consulta',
                'apellidos' => 'Biblioteca',
                'correo' => 'bib.consulta@intranet.local',
                'nombre_usuario' => 'bib.consulta',
                'sistemas' => [
                    'BIB' => 'Consulta Biblioteca',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Administrador',
                'apellidos' => 'Tickets',
                'correo' => 'tik.admin@intranet.local',
                'nombre_usuario' => 'tik.admin',
                'sistemas' => [
                    'TIK' => 'Administrador Tickets',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Gestor',
                'apellidos' => 'Tickets',
                'correo' => 'tik.gestor@intranet.local',
                'nombre_usuario' => 'tik.gestor',
                'sistemas' => [
                    'TIK' => 'Gestor Tickets',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Consulta',
                'apellidos' => 'Tickets',
                'correo' => 'tik.consulta@intranet.local',
                'nombre_usuario' => 'tik.consulta',
                'sistemas' => [
                    'TIK' => 'Consulta Tickets',
                ],
                'area' => 'TIC',
            ],
            [
                'nombres' => 'Empleado',
                'apellidos' => 'Solicitante',
                'correo' => 'empleado@intranet.local',
                'nombre_usuario' => 'empleado',
                'sistemas' => [
                    'TIK' => 'Solicitante',
                    'BIB' => 'Usuario Biblioteca',
                ],
                'area' => 'TIC',
            ],
        ];

        foreach ($usuarios as $usuarioData) {
            DB::table('seg_usuarios')->updateOrInsert(
                ['correo' => $usuarioData['correo']],
                [
                    'nombres' => $usuarioData['nombres'],
                    'apellidos' => $usuarioData['apellidos'],
                    'correo' => $usuarioData['correo'],
                    'nombre_usuario' => $usuarioData['nombre_usuario'],
                    'clave' => Hash::make($this->clave),
                    'activo' => 1,
                    'ultimo_acceso' => null,
                    'remember_token' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );

            $usuario = DB::table('seg_usuarios')
                ->where('correo', $usuarioData['correo'])
                ->first();

            if (!$usuario) {
                continue;
            }

            foreach ($usuarioData['sistemas'] as $codigoSistema => $nombreRol) {
                $sistema = DB::table('seg_sistemas')
                    ->where('codigo', $codigoSistema)
                    ->first();

                if (!$sistema) {
                    continue;
                }

                DB::table('seg_usuario_sistema')->updateOrInsert(
                    [
                        'id_usuario' => $usuario->id_usuario,
                        'id_sistema' => $sistema->id_sistema,
                    ],
                    [
                        'activo' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                $rol = DB::table('seg_roles')
                    ->where('id_sistema', $sistema->id_sistema)
                    ->where('nombre', $nombreRol)
                    ->first();

                if (!$rol) {
                    continue;
                }

                DB::table('seg_usuario_rol')->updateOrInsert(
                    [
                        'id_usuario' => $usuario->id_usuario,
                        'id_rol' => $rol->id_rol,
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            $this->asignarArea($usuario->id_usuario, $usuarioData['area'], $now);
        }
    }

    private function asignarArea(int $idUsuario, string $codigoDepartamento, Carbon $now): void
    {
        $departamento = DB::table('org_departamentos')
            ->where('codigo', $codigoDepartamento)
            ->first();

        $proyecto = DB::table('org_proyectos')
            ->where('codigo', 'NA')
            ->first();

        if (!$departamento || !$proyecto) {
            return;
        }

        $area = DB::table('org_areas')
            ->where('id_departamento', $departamento->id_departamento)
            ->where('id_proyecto', $proyecto->id_proyecto)
            ->first();

        if (!$area) {
            return;
        }

        DB::table('org_usuario_area')->updateOrInsert(
            [
                'id_usuario' => $idUsuario,
                'id_area' => $area->id_area,
            ],
            [
                'es_principal' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}