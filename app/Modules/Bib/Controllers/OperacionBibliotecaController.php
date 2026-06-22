<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\HistorialPrestamo;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Solicitud;

class OperacionBibliotecaController extends Controller
{
    public function index()
    {
        $solicitudesPendientes = Solicitud::whereHas('estadoSolicitud', function ($q) {
            $q->where('codigo', 'PENDIENTE');
        })
            ->where('activo', true)
            ->count();

        $prestamosPendientesEntrega = Prestamo::whereHas('estadoPrestamo', function ($q) {
            $q->where('codigo', 'PENDIENTE_ENTREGA');
        })
            ->where('activo', true)
            ->count();

        $prestamosVencidos = Prestamo::whereHas('estadoPrestamo', function ($q) {
            $q->where('codigo', 'VENCIDO');
        })
            ->where('activo', true)
            ->count();

        $multasPendientes = Multa::where('activo', true)
            ->where('pagada', false)
            ->count();

        $solicitudesPendientesRecientes = Solicitud::query()
            ->with(['usuario', 'recurso', 'estadoSolicitud'])
            ->whereHas('estadoSolicitud', function ($q) {
                $q->where('codigo', 'PENDIENTE');
            })
            ->where('activo', true)
            ->latest('id_solicitud')
            ->limit(5)
            ->get();

        $prestamosPendientesEntregaRecientes = Prestamo::query()
            ->with(['usuario', 'recurso', 'ejemplar', 'estadoPrestamo'])
            ->whereHas('estadoPrestamo', function ($q) {
                $q->where('codigo', 'PENDIENTE_ENTREGA');
            })
            ->where('activo', true)
            ->latest('id_prestamo')
            ->limit(5)
            ->get();

        $prestamosVencidosRecientes = Prestamo::query()
            ->with(['usuario', 'recurso', 'ejemplar', 'estadoPrestamo'])
            ->whereHas('estadoPrestamo', function ($q) {
                $q->where('codigo', 'VENCIDO');
            })
            ->where('activo', true)
            ->latest('id_prestamo')
            ->limit(5)
            ->get();

        $multasPendientesRecientes = Multa::query()
            ->with(['usuario', 'prestamo.recurso'])
            ->where('activo', true)
            ->where('pagada', false)
            ->latest('id_multa')
            ->limit(5)
            ->get();

        $actividadReciente = HistorialPrestamo::query()
            ->with(['prestamo.usuario', 'prestamo.recurso', 'usuarioAccion'])
            ->latest('id_historial_prestamo')
            ->limit(8)
            ->get();

        return view('bib.operacion.index', compact(
            'solicitudesPendientes',
            'prestamosPendientesEntrega',
            'prestamosVencidos',
            'multasPendientes',
            'solicitudesPendientesRecientes',
            'prestamosPendientesEntregaRecientes',
            'prestamosVencidosRecientes',
            'multasPendientesRecientes',
            'actividadReciente'
        ));
    }
}