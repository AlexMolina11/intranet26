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

        $usuario = DB::table('seg_usuarios')
            ->where('correo', 'admin@intranet.local')
            ->first();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'TIK')
            ->first();

        if (!$usuario || !$sistema) {
            return;
        }

        $rol = DB::table('seg_roles')
            ->where('id_sistema', $sistema->id_sistema)
            ->where('nombre', 'Super Administrador')
            ->first();

        if (!$rol) {
            return;
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