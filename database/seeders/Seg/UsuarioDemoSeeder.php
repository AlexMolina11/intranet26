<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuarioDemoSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $usuarios = [
            [
                'nombres' => 'Ana',
                'apellidos' => 'López',
                'correo' => 'ana.lopez@intranet.local',
                'nombre_usuario' => 'ana.lopez',
            ],
            [
                'nombres' => 'Carlos',
                'apellidos' => 'Martínez',
                'correo' => 'carlos.martinez@intranet.local',
                'nombre_usuario' => 'carlos.martinez',
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'Pérez',
                'correo' => 'maria.perez@intranet.local',
                'nombre_usuario' => 'maria.perez',
            ],
        ];

        foreach ($usuarios as $usuario) {
            $existe = DB::table('seg_usuarios')
                ->where('correo', $usuario['correo'])
                ->exists();

            if (!$existe) {
                DB::table('seg_usuarios')->insert([
                    'nombres' => $usuario['nombres'],
                    'apellidos' => $usuario['apellidos'],
                    'correo' => $usuario['correo'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'clave' => Hash::make('Admin2026*'),
                    'activo' => true,
                    'ultimo_acceso' => null,
                    'remember_token' => null,
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ]);
            }
        }
    }
}