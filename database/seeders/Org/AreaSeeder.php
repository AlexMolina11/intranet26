<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $departamentos = DB::table('org_departamentos')
            ->pluck('id_departamento', 'codigo');

        $proyecto = DB::table('org_proyectos')
            ->where('codigo', 'NA')
            ->first();

        if (!$proyecto) {
            return;
        }

        $areas = [
            [
                'codigo_departamento' => 'DIR',
                'nombre' => 'Dirección General',
                'descripcion' => 'Área general para Dirección General',
            ],
            [
                'codigo_departamento' => 'FIN',
                'nombre' => 'Finanzas',
                'descripcion' => 'Área general para Finanzas',
            ],
            [
                'codigo_departamento' => 'TIC',
                'nombre' => 'Tecnología',
                'descripcion' => 'Área general para Tecnología',
            ],
            [
                'codigo_departamento' => 'RRHH',
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Área general para Recursos Humanos',
            ],
            [
                'codigo_departamento' => 'SG',
                'nombre' => 'Servicios Generales',
                'descripcion' => 'Área general para Servicios Generales',
            ],
            [
                'codigo_departamento' => 'COM',
                'nombre' => 'Comunicaciones',
                'descripcion' => 'Área general para Comunicaciones',
            ],
        ];

        foreach ($areas as $area) {
            $idDepartamento = $departamentos[$area['codigo_departamento']] ?? null;

            if (!$idDepartamento) {
                continue;
            }

            DB::table('org_areas')->updateOrInsert(
                [
                    'id_departamento' => $idDepartamento,
                    'id_proyecto' => $proyecto->id_proyecto,
                ],
                [
                    'nombre' => $area['nombre'],
                    'descripcion' => $area['descripcion'],
                    'activo' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}