<?php

namespace App\Modules\Bib\Console\Commands;

use App\Modules\Bib\Models\EstadoPrestamo;
use App\Modules\Bib\Models\HistorialPrestamo;
use App\Modules\Bib\Models\Prestamo;
use Illuminate\Console\Command;

class BibActualizarPrestamosVencidos extends Command
{
    protected $signature = 'bib:actualizar-prestamos-vencidos';

    protected $description = 'Actualiza préstamos entregados vencidos al estado VENCIDO.';

    public function handle(): int
    {
        $estadoEntregado = EstadoPrestamo::query()
            ->where('codigo', 'ENTREGADO')
            ->first();

        $estadoVencido = EstadoPrestamo::query()
            ->where('codigo', 'VENCIDO')
            ->first();

        if (!$estadoEntregado || !$estadoVencido) {
            $this->error('No existen los estados ENTREGADO y/o VENCIDO.');
            return self::FAILURE;
        }

        $prestamos = Prestamo::query()
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->where('id_estado_prestamo', $estadoEntregado->id_estado_prestamo)
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->get();

        foreach ($prestamos as $prestamo) {
            $prestamo->update([
                'id_estado_prestamo' => $estadoVencido->id_estado_prestamo,
            ]);

            HistorialPrestamo::create([
                'id_prestamo' => $prestamo->id_prestamo,
                'id_estado_prestamo' => $estadoVencido->id_estado_prestamo,
                'id_usuario_accion' => null,
                'tipo_movimiento' => 'VENCIMIENTO',
                'fecha_movimiento' => now()->toDateString(),
                'fecha_vencimiento' => $prestamo->fecha_vencimiento,
                'fecha_devolucion' => null,
                'multa_acumulada' => $prestamo->multa_acumulada ?? 0,
                'observaciones' => 'Préstamo marcado automáticamente como vencido.',
                'activo' => true,
            ]);
        }

        $this->info("Préstamos vencidos actualizados: {$prestamos->count()}");

        return self::SUCCESS;
    }
}