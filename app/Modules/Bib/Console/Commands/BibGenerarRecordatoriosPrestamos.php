<?php

namespace App\Modules\Bib\Console\Commands;

use App\Modules\Bib\Models\NotificacionBiblioteca;
use App\Modules\Bib\Models\Prestamo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BibGenerarRecordatoriosPrestamos extends Command
{
    protected $signature = 'bib:generar-recordatorios-prestamos';

    protected $description = 'Genera recordatorios internos para préstamos por vencer y préstamos vencidos.';

    public function handle(): int
    {
        $total = 0;

        $total += $this->generarPorVencer(3);
        $total += $this->generarPorVencer(1);
        $total += $this->generarVencidos();

        $this->info("Recordatorios generados: {$total}");

        return self::SUCCESS;
    }

    private function generarPorVencer(int $dias): int
    {
        $fechaObjetivo = Carbon::parse($this->fechaHoyBaseDatos())
            ->addDays($dias)
            ->toDateString();

        $prestamos = Prestamo::query()
            ->with(['usuario', 'recurso', 'ejemplar', 'estadoPrestamo'])
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereDate('fecha_vencimiento', '=', $fechaObjetivo)
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'ENTREGADO');
            })
            ->get();

        $total = 0;

        foreach ($prestamos as $prestamo) {
            $tipo = "POR_VENCER_{$dias}_DIAS";

            if ($this->crearNotificacionSiNoExiste(
                $prestamo,
                $tipo,
                "Préstamo por vencer en {$dias} día(s)",
                'El préstamo del recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '" vence el ' . optional($prestamo->fecha_vencimiento)->format('d/m/Y') . '.'
            )) {
                $total++;
            }
        }

        return $total;
    }

    private function generarVencidos(): int
    {
        $hoy = $this->fechaHoyBaseDatos();

        $prestamos = Prestamo::query()
            ->with(['usuario', 'recurso', 'ejemplar', 'estadoPrestamo'])
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->whereHas('estadoPrestamo', function ($query) {
                $query->whereIn('codigo', ['ENTREGADO', 'VENCIDO']);
            })
            ->get();

        $total = 0;

        foreach ($prestamos as $prestamo) {
            if ($this->crearNotificacionSiNoExiste(
                $prestamo,
                'PRESTAMO_VENCIDO',
                'Préstamo vencido',
                'El préstamo del recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '" está vencido desde el ' . optional($prestamo->fecha_vencimiento)->format('d/m/Y') . '.'
            )) {
                $total++;
            }
        }

        return $total;
    }

    private function crearNotificacionSiNoExiste(
        Prestamo $prestamo,
        string $tipo,
        string $titulo,
        string $mensaje
    ): bool {
        $hoy = $this->fechaHoyBaseDatos();

        $existe = NotificacionBiblioteca::query()
            ->where('id_usuario', $prestamo->id_usuario)
            ->where('id_prestamo', $prestamo->id_prestamo)
            ->where('tipo', $tipo)
            ->whereDate('fecha_notificacion', '=', $hoy)
            ->exists();

        if ($existe) {
            return false;
        }

        NotificacionBiblioteca::create([
            'id_usuario' => $prestamo->id_usuario,
            'id_prestamo' => $prestamo->id_prestamo,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'fecha_notificacion' => $hoy,
            'leida' => false,
            'activo' => true,
        ]);

        return true;
    }

    private function fechaHoyBaseDatos(): string
    {
        return DB::selectOne('SELECT CURDATE() AS fecha')->fecha;
    }
}