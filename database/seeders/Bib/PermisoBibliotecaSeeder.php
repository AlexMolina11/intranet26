<?php

namespace Database\Seeders\Bib;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermisoBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'BIB')
            ->first();

        if (!$sistema) {
            return;
        }

        $permisos = [
            ['codigo' => 'BIB_VER', 'nombre' => 'Acceso general al módulo Biblioteca'],
            ['codigo' => 'BIB_DASHBOARD_VER', 'nombre' => 'Ver dashboard de Biblioteca'],

            ['codigo' => 'BIB_CATALOGOS_VER', 'nombre' => 'Ver catálogos de biblioteca'],
            ['codigo' => 'BIB_CATALOGOS_CREAR', 'nombre' => 'Crear catálogos de biblioteca'],
            ['codigo' => 'BIB_CATALOGOS_EDITAR', 'nombre' => 'Editar catálogos de biblioteca'],

            ['codigo' => 'BIB_RECURSOS_VER', 'nombre' => 'Ver recursos bibliográficos'],
            ['codigo' => 'BIB_RECURSOS_CREAR', 'nombre' => 'Crear recursos bibliográficos'],
            ['codigo' => 'BIB_RECURSOS_EDITAR', 'nombre' => 'Editar recursos bibliográficos'],

            ['codigo' => 'BIB_EJEMPLARES_VER', 'nombre' => 'Ver ejemplares'],
            ['codigo' => 'BIB_EJEMPLARES_CREAR', 'nombre' => 'Crear ejemplares'],
            ['codigo' => 'BIB_EJEMPLARES_EDITAR', 'nombre' => 'Editar ejemplares'],

            ['codigo' => 'BIB_SOLICITUDES_VER', 'nombre' => 'Ver solicitudes bibliográficas'],
            ['codigo' => 'BIB_SOLICITUDES_CREAR', 'nombre' => 'Crear solicitudes bibliográficas'],
            ['codigo' => 'BIB_SOLICITUDES_GESTIONAR', 'nombre' => 'Gestionar solicitudes bibliográficas'],

            ['codigo' => 'BIB_PRESTAMOS_VER', 'nombre' => 'Ver préstamos'],
            ['codigo' => 'BIB_PRESTAMOS_CREAR', 'nombre' => 'Registrar préstamos'],
            ['codigo' => 'BIB_PRESTAMOS_DEVOLVER', 'nombre' => 'Registrar devoluciones y renovaciones'],

            ['codigo' => 'BIB_MULTAS_VER', 'nombre' => 'Ver multas'],
            ['codigo' => 'BIB_MULTAS_GESTIONAR', 'nombre' => 'Gestionar multas'],

            ['codigo' => 'BIB_POLITICAS_VER', 'nombre' => 'Ver políticas de préstamo'],
            ['codigo' => 'BIB_POLITICAS_EDITAR', 'nombre' => 'Editar políticas de préstamo'],

            ['codigo' => 'BIB_CONSULTA_VER', 'nombre' => 'Realizar consulta bibliográfica'],
        ];

        foreach ($permisos as $permiso) {
            DB::table('seg_permisos')->updateOrInsert(
                [
                    'id_sistema' => $sistema->id_sistema,
                    'codigo' => $permiso['codigo'],
                ],
                [
                    'nombre' => $permiso['nombre'],
                    'descripcion' => $permiso['nombre'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}