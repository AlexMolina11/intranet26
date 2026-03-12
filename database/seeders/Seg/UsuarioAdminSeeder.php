<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('seg_usuarios')->updateOrInsert(
            ['correo' => 'admin@intranet.local'],
            [
                'nombres' => 'Administrador',
                'apellidos' => 'General',
                'correo' => 'admin@intranet.local',
                'nombre_usuario' => 'admin',
                'clave' => Hash::make('Admin2026*'),
                'activo' => 1,
                'ultimo_acceso' => null,
                'remember_token' => null,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        $usuario = DB::table('seg_usuarios')
            ->where('correo', 'admin@intranet.local')
            ->first();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'INTRANET')
            ->first();

        $rol = DB::table('seg_roles')
            ->where('id_sistema', $sistema->id_sistema ?? 0)
            ->where('nombre', 'Super Administrador')
            ->first();

        if ($usuario && $sistema) {
            DB::table('seg_usuario_sistema')->updateOrInsert(
                [
                    'id_usuario' => $usuario->id_usuario,
                    'id_sistema' => $sistema->id_sistema,
                ],
                [
                    'activo' => 1,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        if ($usuario && $rol) {
            DB::table('seg_usuario_rol')->updateOrInsert(
                [
                    'id_usuario' => $usuario->id_usuario,
                    'id_rol' => $rol->id_rol,
                ],
                [
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        if ($usuario) {
            $permisos = DB::table('seg_permisos')->get();

            foreach ($permisos as $permiso) {
                DB::table('seg_usuario_permiso')->updateOrInsert(
                    [
                        'id_usuario' => $usuario->id_usuario,
                        'id_permiso' => $permiso->id_permiso,
                    ],
                    [
                        'permitido' => 1,
                        'updated_at' => $now,
                        'created_at' => $now,
                    ]
                );
            }
        }
    }
}