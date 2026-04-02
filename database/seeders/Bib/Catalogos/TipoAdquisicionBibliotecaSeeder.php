<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAdquisicionBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['codigo' => 'COMPRA', 'nombre' => 'Compra', 'descripcion' => 'Recurso adquirido por compra.', 'orden' => 1, 'activo' => true],
            ['codigo' => 'DONACION', 'nombre' => 'Donación', 'descripcion' => 'Recurso recibido como donación.', 'orden' => 2, 'activo' => true],
            ['codigo' => 'CANJE', 'nombre' => 'Canje', 'descripcion' => 'Recurso recibido por intercambio.', 'orden' => 3, 'activo' => true],
        ];

        foreach ($items as $item) {
            DB::table('bib_tipos_adquisicion')->updateOrInsert(
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