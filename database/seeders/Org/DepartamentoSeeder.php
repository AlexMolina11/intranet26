<?php

namespace Database\Seeders\Org;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        DB::table('org_departamentos')->insert([
            [
                'codigo' => 'DIR',
                'nombre' => 'Dirección General',
                'descripcion' => 'Departamento de dirección institucional',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'codigo' => 'FIN',
                'nombre' => 'Finanzas',
                'descripcion' => 'Departamento financiero',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'codigo' => 'TIC',
                'nombre' => 'Tecnología',
                'descripcion' => 'Departamento de tecnología',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
            [
                'codigo' => 'RRHH',
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Departamento de talento humano',
                'activo' => true,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ],
        ]);
    }
}