<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TikUsuarioSistemaSeeder extends Seeder
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

        $correos = [
            'admin@intranet.local',
            'admin.tickets@intranet.local',
            'gestor.tickets@intranet.local',
            'solicitante1@intranet.local',
            'solicitante2@intranet.local',
            'consulta.tickets@intranet.local',
        ];

        $usuarios = DB::table('seg_usuarios')
            ->whereIn('correo', $correos)
            ->get();

        foreach ($usuarios as $usuario) {
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
}