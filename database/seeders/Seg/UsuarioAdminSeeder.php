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
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );
    }
}