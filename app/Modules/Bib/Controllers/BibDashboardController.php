<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\HistorialPrestamo;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\NotificacionBiblioteca;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use App\Modules\Bib\Models\TipoRecurso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

        $solicitudesAprobadasPendientesEntrega = Solicitud::query()
            ->where('activo', true)
            ->whereHas('estadoSolicitud', function ($query) {
                $query->where('codigo', 'APROBADA');
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

        $prestamosVencenHoy = Prestamo::query()
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'ENTREGADO');
            })
            ->whereDate('fecha_vencimiento', now()->toDateString())
            ->count();

        $prestamosPorVencer = Prestamo::query()
            ->where('activo', true)
            ->whereNull('fecha_devolucion')
            ->whereHas('estadoPrestamo', function ($query) {
                $query->where('codigo', 'ENTREGADO');
            })
            ->whereDate('fecha_vencimiento', '>', now()->toDateString())
            ->whereDate('fecha_vencimiento', '<=', now()->addDays(2)->toDateString())
            ->count();

        $multasPendientes = Multa::query()
            ->where('activo', true)
            ->where('pagada', false)
            ->count();

        $montoMultasPendientes = Multa::query()
            ->where('activo', true)
            ->where('pagada', false)
            ->selectRaw('SUM(monto - monto_pagado) as total')
            ->value('total') ?? 0;

        $recursosSinEjemplares = Recurso::query()
            ->where('activo', true)
            ->whereDoesntHave('ejemplares')
            ->count();

        $tiposRecursoSinPolitica = TipoRecurso::query()
            ->where('activo', true)
            ->whereDoesntHave('politicaPrestamo')
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

        $topRecursosMasPrestados = Recurso::query()
            ->select([
                'bib_recursos.id_recurso',
                'bib_recursos.codigo',
                'bib_recursos.titulo',
                DB::raw('COUNT(bib_prestamos.id_prestamo) AS total_prestamos'),
            ])
            ->leftJoin('bib_prestamos', 'bib_prestamos.id_recurso', '=', 'bib_recursos.id_recurso')
            ->whereNull('bib_recursos.deleted_at')
            ->groupBy('bib_recursos.id_recurso', 'bib_recursos.codigo', 'bib_recursos.titulo')
            ->orderByDesc('total_prestamos')
            ->limit(5)
            ->get();

        $usuariosConMultasPendientes = Multa::query()
            ->select([
                'seg_usuarios.id_usuario',
                'seg_usuarios.nombres',
                'seg_usuarios.apellidos',
                DB::raw('COUNT(bib_multas.id_multa) AS total_multas'),
                DB::raw('SUM(bib_multas.monto - bib_multas.monto_pagado) AS total_pendiente'),
            ])
            ->join('seg_usuarios', 'seg_usuarios.id_usuario', '=', 'bib_multas.id_usuario')
            ->where('bib_multas.activo', true)
            ->where('bib_multas.pagada', false)
            ->whereNull('bib_multas.deleted_at')
            ->groupBy('seg_usuarios.id_usuario', 'seg_usuarios.nombres', 'seg_usuarios.apellidos')
            ->orderByDesc('total_pendiente')
            ->limit(5)
            ->get();

        $ultimosMovimientos = HistorialPrestamo::query()
            ->with([
                'prestamo.usuario:id_usuario,nombres,apellidos',
                'prestamo.recurso:id_recurso,titulo',
                'estadoPrestamo:id_estado_prestamo,codigo,nombre',
                'usuarioAccion:id_usuario,nombres,apellidos',
            ])
            ->latest('id_historial_prestamo')
            ->limit(8)
            ->get();

        $prestamosPorMesRaw = Prestamo::query()
            ->selectRaw("DATE_FORMAT(fecha_prestamo, '%Y-%m') AS mes, COUNT(*) AS total")
            ->whereNotNull('fecha_prestamo')
            ->whereDate('fecha_prestamo', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $prestamosPorMesLabels = [];
        $prestamosPorMesData = [];

        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $clave = $mes->format('Y-m');

            $prestamosPorMesLabels[] = ucfirst($mes->translatedFormat('M Y'));
            $prestamosPorMesData[] = (int) ($prestamosPorMesRaw[$clave] ?? 0);
        }

        $prestamosPorEstado = Prestamo::query()
            ->select([
                'bib_estados_prestamo.nombre',
                DB::raw('COUNT(bib_prestamos.id_prestamo) AS total'),
            ])
            ->join('bib_estados_prestamo', 'bib_estados_prestamo.id_estado_prestamo', '=', 'bib_prestamos.id_estado_prestamo')
            ->groupBy('bib_estados_prestamo.nombre')
            ->orderByDesc('total')
            ->get();

        $prestamosPorEstadoLabels = $prestamosPorEstado->pluck('nombre')->toArray();
        $prestamosPorEstadoData = $prestamosPorEstado->pluck('total')->map(fn ($total) => (int) $total)->toArray();

        $topRecursosLabels = $topRecursosMasPrestados->pluck('titulo')->toArray();
        $topRecursosData = $topRecursosMasPrestados->pluck('total_prestamos')->map(fn ($total) => (int) $total)->toArray();

        return view('bib.dashboard', compact(
            'usuario',
            'totalRecursos',
            'totalEjemplares',
            'ejemplaresDisponibles',
            'ejemplaresPrestados',
            'solicitudesPendientes',
            'solicitudesAprobadasPendientesEntrega',
            'prestamosPendientesEntrega',
            'prestamosActivos',
            'prestamosVencidos',
            'prestamosVencenHoy',
            'prestamosPorVencer',
            'multasPendientes',
            'montoMultasPendientes',
            'recursosSinEjemplares',
            'tiposRecursoSinPolitica',
            'prestamosRecientes',
            'solicitudesRecientes',
            'multasRecientes',
            'accesosRapidos',
            'notificaciones',
            'topRecursosMasPrestados',
            'usuariosConMultasPendientes',
            'ultimosMovimientos',
            'prestamosPorMesLabels',
            'prestamosPorMesData',
            'prestamosPorEstadoLabels',
            'prestamosPorEstadoData',
            'topRecursosLabels',
            'topRecursosData',
        ));
    }
}