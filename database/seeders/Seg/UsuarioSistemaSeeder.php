<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuarioSistemaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $usuario = DB::table('seg_usuarios')
            ->where('correo', 'admin@intranet.local')
            ->first();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'INTRANET')
            ->first();

        if (!$usuario || !$sistema) {
            return;
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
    }
}