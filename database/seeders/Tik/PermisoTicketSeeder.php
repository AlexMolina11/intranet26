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
            // acceso general módulo
            ['codigo' => 'TIK_VER', 'nombre' => 'Acceso general a Tickets'],
            ['codigo' => 'TIK_PANEL_ADMIN_VER', 'nombre' => 'Ver panel administrador de tickets'],
            ['codigo' => 'TIK_PANEL_GESTOR_VER', 'nombre' => 'Ver panel gestor de tickets'],

            // tickets del solicitante
            ['codigo' => 'TIK_TICKETS_VER', 'nombre' => 'Ver tickets propios'],
            ['codigo' => 'TIK_TICKETS_CREAR', 'nombre' => 'Crear tickets'],
            ['codigo' => 'TIK_TICKETS_DETALLE', 'nombre' => 'Ver detalle de tickets propios'],

            // gestión administrativa
            ['codigo' => 'TIK_TICKETS_ASIGNAR', 'nombre' => 'Asignar tickets'],
            ['codigo' => 'TIK_TICKETS_CLASIFICAR', 'nombre' => 'Clasificar tickets como proyecto o no aplica'],
            ['codigo' => 'TIK_TICKETS_ADMIN_VER', 'nombre' => 'Ver tickets del panel administrador'],

            // gestión operativa
            ['codigo' => 'TIK_TICKETS_GESTOR_VER', 'nombre' => 'Ver tickets asignados como gestor'],
            ['codigo' => 'TIK_TICKETS_GESTIONAR', 'nombre' => 'Gestionar tickets'],
            ['codigo' => 'TIK_TICKETS_PLANIFICAR', 'nombre' => 'Planificar tickets'],
            ['codigo' => 'TIK_TICKETS_EJECUTAR', 'nombre' => 'Ejecutar tickets'],
            ['codigo' => 'TIK_TICKETS_CERRAR', 'nombre' => 'Cerrar tickets'],

            // soporte y evaluación (preparados para siguientes días)
            ['codigo' => 'TIK_SOPORTES_VER', 'nombre' => 'Ver soportes'],
            ['codigo' => 'TIK_SOPORTES_CREAR', 'nombre' => 'Crear soportes'],
            ['codigo' => 'TIK_SOPORTES_EVALUAR', 'nombre' => 'Evaluar soportes'],

            // catálogos / flujos
            ['codigo' => 'TIK_CATALOGOS_VER', 'nombre' => 'Ver catálogos de tickets'],
            ['codigo' => 'TIK_CATALOGOS_CREAR', 'nombre' => 'Crear catálogos de tickets'],
            ['codigo' => 'TIK_CATALOGOS_EDITAR', 'nombre' => 'Editar catálogos de tickets'],
            ['codigo' => 'TIK_FLUJOS_VER', 'nombre' => 'Ver flujos de tickets'],
            ['codigo' => 'TIK_FLUJOS_CREAR', 'nombre' => 'Crear flujos de tickets'],
            ['codigo' => 'TIK_FLUJOS_EDITAR', 'nombre' => 'Editar flujos de tickets'],
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