<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    public function index()
    {
        return view('bib.reportes.index');
    }

    public function prestamos(Request $request)
    {
        $query = Prestamo::query()
            ->with(['usuario', 'recurso', 'ejemplar', 'estadoPrestamo'])
            ->latest('id_prestamo');

        if ($request->filled('desde')) {
            $query->whereDate('fecha_prestamo', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_prestamo', '<=', $request->hasta);
        }

        $prestamos = $query->paginate(20)->withQueryString();

        return view('bib.reportes.prestamos', compact('prestamos'));
    }

    public function multas(Request $request)
    {
        $query = Multa::query()
            ->with(['usuario', 'prestamo.recurso'])
            ->latest('id_multa');

        if ($request->filled('desde')) {
            $query->whereDate('fecha_multa', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_multa', '<=', $request->hasta);
        }

        if ($request->filled('pagada') && $request->pagada !== '') {
            $query->where('pagada', (bool) $request->pagada);
        }

        $multas = $query->paginate(20)->withQueryString();

        return view('bib.reportes.multas', compact('multas'));
    }

    public function recursosMasPrestados(Request $request)
    {
        $query = Recurso::query()
            ->select([
                'bib_recursos.id_recurso',
                'bib_recursos.codigo',
                'bib_recursos.titulo',
                DB::raw('COUNT(bib_prestamos.id_prestamo) AS total_prestamos'),
            ])
            ->leftJoin('bib_prestamos', 'bib_prestamos.id_recurso', '=', 'bib_recursos.id_recurso')
            ->whereNull('bib_recursos.deleted_at')
            ->groupBy('bib_recursos.id_recurso', 'bib_recursos.codigo', 'bib_recursos.titulo')
            ->orderByDesc('total_prestamos');

        if ($request->filled('desde')) {
            $query->whereDate('bib_prestamos.fecha_prestamo', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('bib_prestamos.fecha_prestamo', '<=', $request->hasta);
        }

        $recursos = $query->paginate(20)->withQueryString();

        return view('bib.reportes.recursos-mas-prestados', compact('recursos'));
    }

    public function exportarPrestamos(Request $request): StreamedResponse
    {
        $query = Prestamo::query()
            ->with(['usuario', 'recurso', 'ejemplar', 'estadoPrestamo'])
            ->latest('id_prestamo');

        if ($request->filled('desde')) {
            $query->whereDate('fecha_prestamo', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_prestamo', '<=', $request->hasta);
        }

        $prestamos = $query->get();

        return response()->streamDownload(function () use ($prestamos) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Usuario',
                'Recurso',
                'Ejemplar',
                'Fecha préstamo',
                'Fecha vencimiento',
                'Fecha devolución',
                'Estado',
                'Multa acumulada',
            ]);

            foreach ($prestamos as $prestamo) {
                fputcsv($file, [
                    $prestamo->id_prestamo,
                    $prestamo->usuario?->nombre_completo,
                    $prestamo->recurso?->titulo,
                    $prestamo->ejemplar?->codigo_inventario,
                    optional($prestamo->fecha_prestamo)->format('d/m/Y'),
                    optional($prestamo->fecha_vencimiento)->format('d/m/Y'),
                    optional($prestamo->fecha_devolucion)->format('d/m/Y'),
                    $prestamo->estadoPrestamo?->nombre,
                    number_format((float) $prestamo->multa_acumulada, 2, '.', ''),
                ]);
            }

            fclose($file);
        }, 'reporte_prestamos.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportarMultas(Request $request): StreamedResponse
    {
        $query = Multa::query()
            ->with(['usuario', 'prestamo.recurso'])
            ->latest('id_multa');

        if ($request->filled('desde')) {
            $query->whereDate('fecha_multa', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_multa', '<=', $request->hasta);
        }

        if ($request->filled('pagada') && $request->pagada !== '') {
            $query->where('pagada', (bool) $request->pagada);
        }

        $multas = $query->get();

        return response()->streamDownload(function () use ($multas) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Usuario',
                'Recurso',
                'Fecha multa',
                'Días atraso',
                'Monto',
                'Monto pagado',
                'Monto pendiente',
                'Pagada',
                'Motivo',
            ]);

            foreach ($multas as $multa) {
                fputcsv($file, [
                    $multa->id_multa,
                    $multa->usuario?->nombre_completo,
                    $multa->prestamo?->recurso?->titulo,
                    optional($multa->fecha_multa)->format('d/m/Y'),
                    $multa->dias_atraso,
                    number_format((float) $multa->monto, 2, '.', ''),
                    number_format((float) $multa->monto_pagado, 2, '.', ''),
                    number_format((float) $multa->monto - (float) $multa->monto_pagado, 2, '.', ''),
                    $multa->pagada ? 'Sí' : 'No',
                    $multa->motivo,
                ]);
            }

            fclose($file);
        }, 'reporte_multas.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportarRecursosMasPrestados(Request $request): StreamedResponse
    {
        $query = Recurso::query()
            ->select([
                'bib_recursos.id_recurso',
                'bib_recursos.codigo',
                'bib_recursos.titulo',
                DB::raw('COUNT(bib_prestamos.id_prestamo) AS total_prestamos'),
            ])
            ->leftJoin('bib_prestamos', 'bib_prestamos.id_recurso', '=', 'bib_recursos.id_recurso')
            ->whereNull('bib_recursos.deleted_at')
            ->groupBy('bib_recursos.id_recurso', 'bib_recursos.codigo', 'bib_recursos.titulo')
            ->orderByDesc('total_prestamos');

        if ($request->filled('desde')) {
            $query->whereDate('bib_prestamos.fecha_prestamo', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('bib_prestamos.fecha_prestamo', '<=', $request->hasta);
        }

        $recursos = $query->get();

        return response()->streamDownload(function () use ($recursos) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Posición',
                'Código',
                'Recurso',
                'Total préstamos',
            ]);

            foreach ($recursos as $index => $recurso) {
                fputcsv($file, [
                    $index + 1,
                    $recurso->codigo,
                    $recurso->titulo,
                    $recurso->total_prestamos,
                ]);
            }

            fclose($file);
        }, 'reporte_recursos_mas_prestados.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}