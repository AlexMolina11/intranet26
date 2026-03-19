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
            ['codigo' => 'TIK_VER', 'nombre' => 'Ver módulo tickets', 'descripcion' => 'Permite ver el módulo general de tickets.'],
            ['codigo' => 'TIK_CATALOGOS_VER', 'nombre' => 'Ver catálogos tickets', 'descripcion' => 'Permite consultar catálogos del módulo tickets.'],
            ['codigo' => 'TIK_CATALOGOS_ADMIN', 'nombre' => 'Administrar catálogos tickets', 'descripcion' => 'Permite administrar catálogos del módulo tickets.'],
            ['codigo' => 'TIK_FLUJOS_VER', 'nombre' => 'Ver flujos tickets', 'descripcion' => 'Permite consultar flujos del módulo tickets.'],
            ['codigo' => 'TIK_FLUJOS_ADMIN', 'nombre' => 'Administrar flujos tickets', 'descripcion' => 'Permite administrar flujos del módulo tickets.'],
            ['codigo' => 'TIK_TICKETS_VER', 'nombre' => 'Ver tickets', 'descripcion' => 'Permite consultar tickets.'],
            ['codigo' => 'TIK_TICKETS_CREAR', 'nombre' => 'Crear tickets', 'descripcion' => 'Permite registrar tickets.'],
            ['codigo' => 'TIK_TICKETS_EDITAR', 'nombre' => 'Editar tickets', 'descripcion' => 'Permite editar tickets.'],
            ['codigo' => 'TIK_TICKETS_ASIGNAR', 'nombre' => 'Asignar tickets', 'descripcion' => 'Permite asignar tickets a responsables.'],
            ['codigo' => 'TIK_TICKETS_GESTIONAR', 'nombre' => 'Gestionar tickets', 'descripcion' => 'Permite gestionar el flujo del ticket.'],
            ['codigo' => 'TIK_SOPORTES_VER', 'nombre' => 'Ver soportes', 'descripcion' => 'Permite consultar soportes asociados.'],
            ['codigo' => 'TIK_SOPORTES_CREAR', 'nombre' => 'Crear soportes', 'descripcion' => 'Permite registrar seguimientos o soportes.'],
            ['codigo' => 'TIK_ENCUESTAS_VER', 'nombre' => 'Ver encuestas de soporte', 'descripcion' => 'Permite consultar evaluación de soportes.'],
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
                ]
            );
        }
    }
}