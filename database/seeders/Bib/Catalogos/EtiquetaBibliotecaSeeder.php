<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetaBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nombre' => 'Nuevo ingreso', 'descripcion' => 'Material recientemente incorporado.', 'activo' => true],
            ['nombre' => 'Consulta frecuente', 'descripcion' => 'Material de alta consulta.', 'activo' => true],
            ['nombre' => 'Referencia', 'descripcion' => 'Material de apoyo y referencia.', 'activo' => true],
            ['nombre' => 'Colección especial', 'descripcion' => 'Material perteneciente a colección especial.', 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_etiquetas')->updateOrInsert(
                ['nombre' => $item['nombre']],
                array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ])
            );
        }
    }
}