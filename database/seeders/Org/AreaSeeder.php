<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $departamentos = DB::table('org_departamentos')
            ->pluck('id_departamento', 'codigo');

        $proyectos = DB::table('org_proyectos')
            ->pluck('id_proyecto', 'codigo');

        DB::table('org_areas')->insert([
            [
                'id_departamento' => $departamentos['DIR'],
                'id_proyecto' => $proyectos['INST'],
                'nombre' => 'Planificación',
                'descripcion' => 'Área de planificación estratégica',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'id_departamento' => $departamentos['FIN'],
                'id_proyecto' => $proyectos['ADM'],
                'nombre' => 'Presupuesto',
                'descripcion' => 'Área de presupuesto institucional',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'id_departamento' => $departamentos['TIC'],
                'id_proyecto' => $proyectos['SOP'],
                'nombre' => 'Mesa de ayuda',
                'descripcion' => 'Área de soporte técnico',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'id_departamento' => $departamentos['TIC'],
                'id_proyecto' => $proyectos['TD'],
                'nombre' => 'Desarrollo',
                'descripcion' => 'Área de desarrollo de sistemas',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'id_departamento' => $departamentos['RRHH'],
                'id_proyecto' => $proyectos['ADM'],
                'nombre' => 'Talento humano',
                'descripcion' => 'Área de gestión humana',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
        ]);
    }
}