<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TikUsuarioDemoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $usuarios = [
            [
                'nombres' => 'Administrador',
                'apellidos' => 'Tickets',
                'correo' => 'admin.tickets@intranet.local',
                'nombre_usuario' => 'admin.tickets',
            ],
            [
                'nombres' => 'Gestor',
                'apellidos' => 'Tickets',
                'correo' => 'gestor.tickets@intranet.local',
                'nombre_usuario' => 'gestor.tickets',
            ],
            [
                'nombres' => 'Solicitante',
                'apellidos' => 'Uno',
                'correo' => 'solicitante1@intranet.local',
                'nombre_usuario' => 'solicitante1',
            ],
            [
                'nombres' => 'Solicitante',
                'apellidos' => 'Dos',
                'correo' => 'solicitante2@intranet.local',
                'nombre_usuario' => 'solicitante2',
            ],
            [
                'nombres' => 'Consulta',
                'apellidos' => 'Tickets',
                'correo' => 'consulta.tickets@intranet.local',
                'nombre_usuario' => 'consulta.tickets',
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('seg_usuarios')->updateOrInsert(
                ['correo' => $usuario['correo']],
                [
                    'nombres' => $usuario['nombres'],
                    'apellidos' => $usuario['apellidos'],
                    'correo' => $usuario['correo'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'clave' => Hash::make('Admin2026*'),
                    'activo' => 1,
                    'ultimo_acceso' => null,
                    'remember_token' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}