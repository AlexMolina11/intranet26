<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAccesoBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'codigo' => 'SALA',
                'nombre' => 'Consulta en sala',
                'descripcion' => 'Solo puede consultarse dentro de la biblioteca.',
                'permite_prestamo' => false,
                'requiere_autorizacion' => false,
                'orden' => 1,
                'activo' => true,
            ],
            [
                'codigo' => 'EXTERNO',
                'nombre' => 'Préstamo externo',
                'descripcion' => 'Puede salir de biblioteca según política.',
                'permite_prestamo' => true,
                'requiere_autorizacion' => false,
                'orden' => 2,
                'activo' => true,
            ],
            [
                'codigo' => 'RESTRINGIDO',
                'nombre' => 'Acceso restringido',
                'descripcion' => 'Requiere autorización especial.',
                'permite_prestamo' => false,
                'requiere_autorizacion' => true,
                'orden' => 3,
                'activo' => true,
            ],
        ];

        foreach ($items as $item) {
            DB::table('bib_tipos_acceso')->updateOrInsert(
                ['codigo' => $item['codigo']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ])
            );
        }
    }
}