<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use Illuminate\Http\Request;

class BibDashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $totalRecursos = Recurso::query()->count();

        $totalEjemplares = Ejemplar::query()->count();

        $ejemplaresDisponibles = Ejemplar::query()
            ->whereHas('disponibilidad', function ($query) {
                $query->where('codigo', 'DISPONIBLE');
            })
            ->count();

        $solicitudesPendientes = Solicitud::query()
            ->whereHas('estadoSolicitud', function ($query) {
                $query->where('codigo', 'PENDIENTE');
            })
            ->count();

        $prestamosActivos = Prestamo::query()
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->whereIn('codigo', ['PRESTADO', 'ENTREGADO']);
            })
            ->count();

        $prestamosVencidos = Prestamo::query()
            ->whereNull('fecha_devolucion')
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->count();

        $multasPendientes = Multa::query()
            ->where('pagada', false)
            ->count();

        $prestamosRecientes = Prestamo::query()
            ->with([
                'usuario:id_usuario,nombres,apellidos',
                'recurso:id_recurso,titulo',
                'estadoPrestamo:id_estado_prestamo,codigo,nombre',
            ])
            ->latest('id_prestamo')
            ->limit(8)
            ->get();

        $accesosRapidos = collect([
            [
                'label' => 'Recursos',
                'route' => 'bib.recursos.index',
                'icon' => 'fa-solid fa-book',
                'can' => $usuario->tienePermiso('BIB_RECURSOS_VER'),
            ],
            [
                'label' => 'Ejemplares',
                'route' => 'bib.ejemplares.index',
                'icon' => 'fa-solid fa-copy',
                'can' => $usuario->tienePermiso('BIB_EJEMPLARES_VER'),
            ],
            [
                'label' => 'Solicitudes',
                'route' => 'bib.solicitudes.index',
                'icon' => 'fa-solid fa-clipboard-list',
                'can' => $usuario->tienePermiso('BIB_SOLICITUDES_VER'),
            ],
            [
                'label' => 'Préstamos',
                'route' => 'bib.prestamos.index',
                'icon' => 'fa-solid fa-right-left',
                'can' => $usuario->tienePermiso('BIB_PRESTAMOS_VER'),
            ],
            [
                'label' => 'Multas',
                'route' => 'bib.multas.index',
                'icon' => 'fa-solid fa-money-bill-wave',
                'can' => $usuario->tienePermiso('BIB_MULTAS_VER'),
            ],
            [
                'label' => 'Políticas',
                'route' => 'bib.politicas.index',
                'icon' => 'fa-solid fa-scale-balanced',
                'can' => $usuario->tienePermiso('BIB_POLITICAS_VER'),
            ],
            [
                'label' => 'Catálogos',
                'route' => 'bib.config.autores.index',
                'icon' => 'fa-solid fa-sliders',
                'can' => $usuario->tienePermiso('BIB_CATALOGOS_VER'),
            ],
        ])->filter(function ($item) {
            return $item['can'] && \Route::has($item['route']);
        })->values();

        return view('bib.dashboard', compact(
            'usuario',
            'totalRecursos',
            'totalEjemplares',
            'ejemplaresDisponibles',
            'solicitudesPendientes',
            'prestamosActivos',
            'prestamosVencidos',
            'multasPendientes',
            'prestamosRecientes',
            'accesosRapidos'
        ));
    }
}