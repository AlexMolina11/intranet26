<?php

namespace Database\Seeders\Bib;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BibRolSeeder extends Seeder
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

        $roles = [
            [
                'nombre' => 'Super Administrador',
                'descripcion' => 'Acceso total al sistema de biblioteca',
                'activo' => 1,
            ],
            [
                'nombre' => 'Administrador Biblioteca',
                'descripcion' => 'Administra catálogos, recursos, ejemplares y circulación bibliográfica',
                'activo' => 1,
            ],
            [
                'nombre' => 'Bibliotecario',
                'descripcion' => 'Gestiona préstamos, devoluciones, solicitudes y operación de inventario bibliográfico',
                'activo' => 1,
            ],
            [
                'nombre' => 'Consulta Biblioteca',
                'descripcion' => 'Consulta catálogos, recursos y disponibilidad bibliográfica',
                'activo' => 1,
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('seg_roles')->updateOrInsert(
                [
                    'id_sistema' => $sistema->id_sistema,
                    'nombre' => $rol['nombre'],
                ],
                [
                    'descripcion' => $rol['descripcion'],
                    'activo' => $rol['activo'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}