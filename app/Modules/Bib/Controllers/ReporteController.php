<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}