<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Bib\Models\NotificacionBiblioteca;

class BibDashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $totalRecursos = Recurso::query()
            ->where('activo', true)
            ->count();

        $totalEjemplares = Ejemplar::query()
            ->where('activo', true)
            ->count();

        $ejemplaresDisponibles = Ejemplar::query()
            ->where('activo', true)
            ->whereHas('disponibilidad', function ($query) {
                $query->where('codigo', 'DISPONIBLE');
            })
            ->count();

        $ejemplaresPrestados = Ejemplar::query()
            ->where('activo', true)
            ->whereHas('disponibilidad', function ($query) {
                $query->where('codigo', 'PRESTADO');
            })
            ->count();

        $solicitudesPendientes = Solicitud::query()
            ->where('activo', true)
            ->whereHas('estadoSolicitud', function ($query) {
                $query->where('codigo', 'PENDIENTE');
            })
            ->count();

        $prestamosPendientesEntrega = Prestamo::query()
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'PENDIENTE_ENTREGA');
            })
            ->count();

        $prestamosActivos = Prestamo::query()
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'ENTREGADO');
            })
            ->count();

        $prestamosVencidos = Prestamo::query()
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'ENTREGADO');
            })
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->count();

        $multasPendientes = Multa::query()
            ->where('activo', true)
            ->where('pagada', false)
            ->count();

        $prestamosRecientes = Prestamo::query()
            ->with([
                'usuario:id_usuario,nombres,apellidos',
                'recurso:id_recurso,titulo',
                'ejemplar:id_ejemplar,codigo_inventario',
                'estadoPrestamo:id_estado_prestamo,codigo,nombre',
            ])
            ->latest('id_prestamo')
            ->limit(8)
            ->get();

        $solicitudesRecientes = Solicitud::query()
            ->with([
                'usuario:id_usuario,nombres,apellidos',
                'recurso:id_recurso,titulo',
                'estadoSolicitud:id_estado_solicitud,codigo,nombre',
            ])
            ->latest('id_solicitud')
            ->limit(6)
            ->get();

        $multasRecientes = Multa::query()
            ->with([
                'usuario:id_usuario,nombres,apellidos',
                'prestamo:id_prestamo,id_recurso,id_ejemplar',
                'prestamo.recurso:id_recurso,titulo',
            ])
            ->latest('id_multa')
            ->limit(6)
            ->get();

        $accesosRapidos = collect([
            [
                'label' => 'Consulta',
                'route' => 'bib.consulta.index',
                'icon' => 'fa-solid fa-magnifying-glass',
                'can' => $usuario->tienePermiso('BIB_CONSULTA_VER'),
            ],
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
            return $item['can'] && Route::has($item['route']);
        })->values();

        $notificaciones = NotificacionBiblioteca::query()
            ->with(['prestamo.recurso'])
            ->where('activo', true)
            ->where('id_usuario', $usuario->id_usuario)
            ->where('leida', false)
            ->latest('id_notificacion')
            ->limit(5)
            ->get();

        return view('bib.dashboard', compact(
            'usuario',
            'totalRecursos',
            'totalEjemplares',
            'ejemplaresDisponibles',
            'ejemplaresPrestados',
            'solicitudesPendientes',
            'prestamosPendientesEntrega',
            'prestamosActivos',
            'prestamosVencidos',
            'multasPendientes',
            'prestamosRecientes',
            'solicitudesRecientes',
            'multasRecientes',
            'accesosRapidos',
            'notificaciones'
        ));
    }
}