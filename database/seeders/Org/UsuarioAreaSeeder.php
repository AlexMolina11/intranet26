<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuarioAreaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $usuario = DB::table('seg_usuarios')
            ->where('correo', 'admin@intranet.local')
            ->first();

        $departamento = DB::table('org_departamentos')
            ->where('codigo', 'TIC')
            ->first();

        $proyecto = DB::table('org_proyectos')
            ->where('codigo', 'NA')
            ->first();

        if (!$usuario || !$departamento || !$proyecto) {
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
                'id_usuario' => $usuario->id_usuario,
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