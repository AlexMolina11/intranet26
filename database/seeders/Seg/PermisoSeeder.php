<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'INTRANET')
            ->first();

        if (!$sistema) {
            return;
        }

        $permisos = [
            // Dashboard
            ['codigo' => 'DASHBOARD_VER', 'nombre' => 'Ver dashboard', 'descripcion' => 'Permite visualizar el dashboard'],

            // Usuarios
            ['codigo' => 'USUARIOS_VER', 'nombre' => 'Ver usuarios', 'descripcion' => 'Permite visualizar usuarios'],
            ['codigo' => 'USUARIOS_CREAR', 'nombre' => 'Crear usuarios', 'descripcion' => 'Permite crear usuarios'],
            ['codigo' => 'USUARIOS_EDITAR', 'nombre' => 'Editar usuarios', 'descripcion' => 'Permite editar usuarios'],
            ['codigo' => 'USUARIOS_ELIMINAR', 'nombre' => 'Eliminar usuarios', 'descripcion' => 'Permite eliminar usuarios'],

            // Sistemas
            ['codigo' => 'SISTEMAS_VER', 'nombre' => 'Ver sistemas', 'descripcion' => 'Permite visualizar sistemas'],
            ['codigo' => 'SISTEMAS_CREAR', 'nombre' => 'Crear sistemas', 'descripcion' => 'Permite crear sistemas'],
            ['codigo' => 'SISTEMAS_EDITAR', 'nombre' => 'Editar sistemas', 'descripcion' => 'Permite editar sistemas'],
            ['codigo' => 'SISTEMAS_ELIMINAR', 'nombre' => 'Eliminar sistemas', 'descripcion' => 'Permite eliminar sistemas'],

            // Roles
            ['codigo' => 'ROLES_VER', 'nombre' => 'Ver roles', 'descripcion' => 'Permite visualizar roles'],
            ['codigo' => 'ROLES_CREAR', 'nombre' => 'Crear roles', 'descripcion' => 'Permite crear roles'],
            ['codigo' => 'ROLES_EDITAR', 'nombre' => 'Editar roles', 'descripcion' => 'Permite editar roles'],
            ['codigo' => 'ROLES_ELIMINAR', 'nombre' => 'Eliminar roles', 'descripcion' => 'Permite eliminar roles'],
            ['codigo' => 'ROLES_ASIGNAR', 'nombre' => 'Asignar roles', 'descripcion' => 'Permite asignar roles'],

            // Permisos
            ['codigo' => 'PERMISOS_VER', 'nombre' => 'Ver permisos', 'descripcion' => 'Permite visualizar permisos'],
            ['codigo' => 'PERMISOS_CREAR', 'nombre' => 'Crear permisos', 'descripcion' => 'Permite crear permisos'],
            ['codigo' => 'PERMISOS_EDITAR', 'nombre' => 'Editar permisos', 'descripcion' => 'Permite editar permisos'],
            ['codigo' => 'PERMISOS_ELIMINAR', 'nombre' => 'Eliminar permisos', 'descripcion' => 'Permite eliminar permisos'],
            ['codigo' => 'PERMISOS_ASIGNAR', 'nombre' => 'Asignar permisos', 'descripcion' => 'Permite asignar permisos'],

            // Menús
            ['codigo' => 'MENUS_VER', 'nombre' => 'Ver menús', 'descripcion' => 'Permite visualizar menús'],
            ['codigo' => 'MENUS_CREAR', 'nombre' => 'Crear menús', 'descripcion' => 'Permite crear menús'],
            ['codigo' => 'MENUS_EDITAR', 'nombre' => 'Editar menús', 'descripcion' => 'Permite editar menús'],
            ['codigo' => 'MENUS_ELIMINAR', 'nombre' => 'Eliminar menús', 'descripcion' => 'Permite eliminar menús'],

            // Menu items
            ['codigo' => 'MENU_ITEMS_VER', 'nombre' => 'Ver items de menú', 'descripcion' => 'Permite visualizar items de menú'],
            ['codigo' => 'MENU_ITEMS_CREAR', 'nombre' => 'Crear items de menú', 'descripcion' => 'Permite crear items de menú'],
            ['codigo' => 'MENU_ITEMS_EDITAR', 'nombre' => 'Editar items de menú', 'descripcion' => 'Permite editar items de menú'],
            ['codigo' => 'MENU_ITEMS_ELIMINAR', 'nombre' => 'Eliminar items de menú', 'descripcion' => 'Permite eliminar items de menú'],

            // Organización - departamentos
            ['codigo' => 'ORG_DEPARTAMENTOS_VER', 'nombre' => 'Ver departamentos', 'descripcion' => 'Permite visualizar departamentos'],
            ['codigo' => 'ORG_DEPARTAMENTOS_CREAR', 'nombre' => 'Crear departamentos', 'descripcion' => 'Permite crear departamentos'],
            ['codigo' => 'ORG_DEPARTAMENTOS_EDITAR', 'nombre' => 'Editar departamentos', 'descripcion' => 'Permite editar departamentos'],
            ['codigo' => 'ORG_DEPARTAMENTOS_ELIMINAR', 'nombre' => 'Eliminar departamentos', 'descripcion' => 'Permite eliminar departamentos'],

            // Organización - proyectos
            ['codigo' => 'ORG_PROYECTOS_VER', 'nombre' => 'Ver proyectos', 'descripcion' => 'Permite visualizar proyectos'],
            ['codigo' => 'ORG_PROYECTOS_CREAR', 'nombre' => 'Crear proyectos', 'descripcion' => 'Permite crear proyectos'],
            ['codigo' => 'ORG_PROYECTOS_EDITAR', 'nombre' => 'Editar proyectos', 'descripcion' => 'Permite editar proyectos'],
            ['codigo' => 'ORG_PROYECTOS_ELIMINAR', 'nombre' => 'Eliminar proyectos', 'descripcion' => 'Permite eliminar proyectos'],

            // Organización - áreas
            ['codigo' => 'ORG_AREAS_VER', 'nombre' => 'Ver áreas', 'descripcion' => 'Permite visualizar áreas'],
            ['codigo' => 'ORG_AREAS_CREAR', 'nombre' => 'Crear áreas', 'descripcion' => 'Permite crear áreas'],
            ['codigo' => 'ORG_AREAS_EDITAR', 'nombre' => 'Editar áreas', 'descripcion' => 'Permite editar áreas'],
            ['codigo' => 'ORG_AREAS_ELIMINAR', 'nombre' => 'Eliminar áreas', 'descripcion' => 'Permite eliminar áreas'],

            // Organización - usuario área
            ['codigo' => 'ORG_USUARIO_AREA_VER', 'nombre' => 'Ver asignaciones organizacionales', 'descripcion' => 'Permite visualizar asignaciones de usuario a área'],
            ['codigo' => 'ORG_USUARIO_AREA_ASIGNAR', 'nombre' => 'Asignar usuario a área', 'descripcion' => 'Permite asignar usuarios a áreas'],
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