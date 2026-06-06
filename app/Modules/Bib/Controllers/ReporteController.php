<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

    public function exportarPrestamos(Request $request)
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

        $filas = $query->get()->map(function ($prestamo) {
            return [
                $prestamo->id_prestamo,
                $prestamo->usuario?->nombre_completo,
                $prestamo->recurso?->titulo,
                $prestamo->ejemplar?->codigo_inventario,
                optional($prestamo->fecha_prestamo)->format('d/m/Y'),
                optional($prestamo->fecha_vencimiento)->format('d/m/Y'),
                optional($prestamo->fecha_devolucion)->format('d/m/Y'),
                $prestamo->estadoPrestamo?->nombre,
                (float) $prestamo->multa_acumulada,
            ];
        })->toArray();

        return $this->descargarExcel('reporte_prestamos.xlsx', [
            'ID',
            'Usuario',
            'Recurso',
            'Ejemplar',
            'Fecha préstamo',
            'Fecha vencimiento',
            'Fecha devolución',
            'Estado',
            'Multa acumulada',
        ], $filas);
    }

    public function exportarMultas(Request $request)
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

        $filas = $query->get()->map(function ($multa) {
            return [
                $multa->id_multa,
                $multa->usuario?->nombre_completo,
                $multa->prestamo?->recurso?->titulo,
                optional($multa->fecha_multa)->format('d/m/Y'),
                $multa->dias_atraso,
                (float) $multa->monto,
                (float) $multa->monto_pagado,
                (float) $multa->monto - (float) $multa->monto_pagado,
                $multa->pagada ? 'Sí' : 'No',
                $multa->motivo,
            ];
        })->toArray();

        return $this->descargarExcel('reporte_multas.xlsx', [
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
        ], $filas);
    }

    public function exportarRecursosMasPrestados(Request $request)
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

        $filas = $query->get()->map(function ($recurso, $index) {
            return [
                $index + 1,
                $recurso->codigo,
                $recurso->titulo,
                (int) $recurso->total_prestamos,
            ];
        })->toArray();

        return $this->descargarExcel('reporte_recursos_mas_prestados.xlsx', [
            'Posición',
            'Código',
            'Recurso',
            'Total préstamos',
        ], $filas);
    }

    private function descargarExcel(string $nombreArchivo, array $encabezados, array $filas)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($encabezados, null, 'A1');
        $sheet->fromArray($filas, null, 'A2');

        $ultimaColumna = $sheet->getHighestColumn();
        $ultimaFila = $sheet->getHighestRow();

        $sheet->getStyle("A1:{$ultimaColumna}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '385506'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle("A1:{$ultimaColumna}{$ultimaFila}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        foreach (range('A', $ultimaColumna) as $columna) {
            $sheet->getColumnDimension($columna)->setAutoSize(true);
        }

        $sheet->freezePane('A2');

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $nombreArchivo, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}