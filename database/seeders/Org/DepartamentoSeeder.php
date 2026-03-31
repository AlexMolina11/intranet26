<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $departamentos = [
            [
                'codigo' => 'DIR',
                'nombre' => 'Dirección General',
                'descripcion' => 'Departamento de dirección institucional',
                'activo' => 1,
            ],
            [
                'codigo' => 'FIN',
                'nombre' => 'Finanzas',
                'descripcion' => 'Departamento financiero',
                'activo' => 1,
            ],
            [
                'codigo' => 'TIC',
                'nombre' => 'Tecnología',
                'descripcion' => 'Departamento de tecnología',
                'activo' => 1,
            ],
            [
                'codigo' => 'RRHH',
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Departamento de talento humano',
                'activo' => 1,
            ],
            [
                'codigo' => 'SG',
                'nombre' => 'Servicios Generales',
                'descripcion' => 'Departamento de servicios generales',
                'activo' => 1,
            ],
            [
                'codigo' => 'COM',
                'nombre' => 'Comunicaciones',
                'descripcion' => 'Departamento de comunicaciones',
                'activo' => 1,
            ],
        ];

        foreach ($departamentos as $departamento) {
            DB::table('org_departamentos')->updateOrInsert(
                ['codigo' => $departamento['codigo']],
                [
                    'nombre' => $departamento['nombre'],
                    'descripcion' => $departamento['descripcion'],
                    'activo' => $departamento['activo'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}