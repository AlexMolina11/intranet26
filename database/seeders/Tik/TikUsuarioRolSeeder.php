<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TikUsuarioRolSeeder extends Seeder
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

        $asignaciones = [
            'admin@intranet.local' => 'Super Administrador',
            'admin.tickets@intranet.local' => 'Administrador Tickets',
            'gestor.tickets@intranet.local' => 'Gestor Tickets',
            'solicitante1@intranet.local' => 'Solicitante',
            'solicitante2@intranet.local' => 'Solicitante',
            'consulta.tickets@intranet.local' => 'Consulta Tickets',
        ];

        foreach ($asignaciones as $correo => $nombreRol) {
            $usuario = DB::table('seg_usuarios')
                ->where('correo', $correo)
                ->first();

            $rol = $roles->get($nombreRol);

            if (!$usuario || !$rol) {
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
    }
}