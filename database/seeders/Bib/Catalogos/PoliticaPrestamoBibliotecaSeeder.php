<?php

namespace Database\Seeders\Bib\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliticaPrestamoBibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = DB::table('bib_tipos_recurso')
            ->whereNull('deleted_at')
            ->orderBy('orden')
            ->get();

        foreach ($tipos as $tipo) {
            $permiteReserva = in_array($tipo->codigo, ['LIBRO', 'TESIS']);
            $requiereAprobacion = in_array($tipo->codigo, ['TESIS']);
            $permitePrestamoExterno = !in_array($tipo->codigo, ['DIGITAL']);

            DB::table('bib_politicas_prestamo')->updateOrInsert(
                ['id_tipo_recurso' => $tipo->id_tipo_recurso],
                [
                    'dias_prestamo' => (int) $tipo->dias_prestamo_default,
                    'max_renovaciones' => (int) $tipo->renovaciones_default,
                    'max_prestamos_usuario' => $tipo->codigo === 'REVISTA' ? 1 : 2,
                    'multa_diaria' => $tipo->multa_diaria_default,
                    'permite_reserva' => $permiteReserva,
                    'requiere_aprobacion' => $requiereAprobacion,
                    'permite_prestamo_externo' => $permitePrestamoExterno,
                    'observaciones' => null,
                    'orden' => (int) $tipo->orden,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]
            );
        }
    }
}