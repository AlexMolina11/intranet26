<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsuarioAreaSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $usuarios = DB::table('seg_usuarios')->pluck('id_usuario', 'correo');
        $areas = DB::table('org_areas')->pluck('id_area', 'nombre');

        $registros = [
            [
                'id_usuario' => $usuarios['ana.lopez@intranet.local'] ?? null,
                'id_area' => $areas['Desarrollo'] ?? null,
                'es_principal' => true,
            ],
            [
                'id_usuario' => $usuarios['ana.lopez@intranet.local'] ?? null,
                'id_area' => $areas['Mesa de ayuda'] ?? null,
                'es_principal' => false,
            ],
            [
                'id_usuario' => $usuarios['carlos.martinez@intranet.local'] ?? null,
                'id_area' => $areas['Presupuesto'] ?? null,
                'es_principal' => true,
            ],
            [
                'id_usuario' => $usuarios['maria.perez@intranet.local'] ?? null,
                'id_area' => $areas['Talento humano'] ?? null,
                'es_principal' => true,
            ],
            [
                'id_usuario' => $usuarios['maria.perez@intranet.local'] ?? null,
                'id_area' => $areas['Planificación'] ?? null,
                'es_principal' => false,
            ],
        ];

        foreach ($registros as $registro) {
            if (!$registro['id_usuario'] || !$registro['id_area']) {
                continue;
            }

            $existe = DB::table('org_usuario_area')
                ->where('id_usuario', $registro['id_usuario'])
                ->where('id_area', $registro['id_area'])
                ->exists();

            if (!$existe) {
                DB::table('org_usuario_area')->insert([
                    'id_usuario' => $registro['id_usuario'],
                    'id_area' => $registro['id_area'],
                    'es_principal' => $registro['es_principal'],
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ]);
            }
        }
    }
}