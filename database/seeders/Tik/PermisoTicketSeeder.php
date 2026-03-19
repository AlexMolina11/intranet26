<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermisoTicketSeeder extends Seeder
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

        $permisos = [
            ['codigo' => 'TIK_VER', 'nombre' => 'Ver módulo tickets', 'descripcion' => 'Permite ver el módulo general de tickets'],
            ['codigo' => 'TIK_CATALOGOS_VER', 'nombre' => 'Ver catálogos tickets', 'descripcion' => 'Permite consultar catálogos del módulo tickets'],
            ['codigo' => 'TIK_CATALOGOS_CREAR', 'nombre' => 'Crear catálogos tickets', 'descripcion' => 'Permite crear registros de catálogos del módulo tickets'],
            ['codigo' => 'TIK_CATALOGOS_EDITAR', 'nombre' => 'Editar catálogos tickets', 'descripcion' => 'Permite editar registros de catálogos del módulo tickets'],
            ['codigo' => 'TIK_CATALOGOS_ELIMINAR', 'nombre' => 'Eliminar catálogos tickets', 'descripcion' => 'Permite eliminar registros de catálogos del módulo tickets'],

            ['codigo' => 'TIK_FLUJOS_VER', 'nombre' => 'Ver flujos tickets', 'descripcion' => 'Permite consultar flujos del módulo tickets'],
            ['codigo' => 'TIK_FLUJOS_CREAR', 'nombre' => 'Crear flujos tickets', 'descripcion' => 'Permite crear flujos del módulo tickets'],
            ['codigo' => 'TIK_FLUJOS_EDITAR', 'nombre' => 'Editar flujos tickets', 'descripcion' => 'Permite editar flujos del módulo tickets'],
            ['codigo' => 'TIK_FLUJOS_ELIMINAR', 'nombre' => 'Eliminar flujos tickets', 'descripcion' => 'Permite eliminar flujos del módulo tickets'],

            ['codigo' => 'TIK_TICKETS_VER', 'nombre' => 'Ver tickets', 'descripcion' => 'Permite consultar tickets'],
            ['codigo' => 'TIK_TICKETS_CREAR', 'nombre' => 'Crear tickets', 'descripcion' => 'Permite registrar tickets'],
            ['codigo' => 'TIK_TICKETS_EDITAR', 'nombre' => 'Editar tickets', 'descripcion' => 'Permite editar tickets'],
            ['codigo' => 'TIK_TICKETS_ASIGNAR', 'nombre' => 'Asignar tickets', 'descripcion' => 'Permite asignar tickets a responsables'],
            ['codigo' => 'TIK_TICKETS_GESTIONAR', 'nombre' => 'Gestionar tickets', 'descripcion' => 'Permite gestionar el flujo del ticket'],

            ['codigo' => 'TIK_SOPORTES_VER', 'nombre' => 'Ver soportes', 'descripcion' => 'Permite consultar soportes asociados'],
            ['codigo' => 'TIK_SOPORTES_CREAR', 'nombre' => 'Crear soportes', 'descripcion' => 'Permite registrar seguimientos o soportes'],
            ['codigo' => 'TIK_SOPORTES_EDITAR', 'nombre' => 'Editar soportes', 'descripcion' => 'Permite editar soportes'],
            ['codigo' => 'TIK_SOPORTES_ELIMINAR', 'nombre' => 'Eliminar soportes', 'descripcion' => 'Permite eliminar soportes'],

            ['codigo' => 'TIK_ENCUESTAS_VER', 'nombre' => 'Ver encuestas de soporte', 'descripcion' => 'Permite consultar evaluaciones de soportes'],
        ];

        foreach ($permisos as $permiso) {
            DB::table('seg_permisos')->updateOrInsert(
                ['codigo' => $permiso['codigo']],
                [
                    'id_sistema' => $sistema->id_sistema,
                    'nombre' => $permiso['nombre'],
                    'descripcion' => $permiso['descripcion'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}