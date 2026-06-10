<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Solicitud;
use Illuminate\Http\Request;

class PerfilBibliotecaController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $prestamosActivos = Prestamo::with(['recurso', 'ejemplar', 'estadoPrestamo'])
            ->where('id_usuario', $usuario->id_usuario)
            ->whereNull('fecha_devolucion')
            ->latest('id_prestamo')
            ->get();

        $historialPrestamos = Prestamo::with(['recurso', 'ejemplar', 'estadoPrestamo'])
            ->where('id_usuario', $usuario->id_usuario)
            ->whereNotNull('fecha_devolucion')
            ->latest('id_prestamo')
            ->limit(10)
            ->get();

        $solicitudes = Solicitud::with(['recurso', 'ejemplar', 'estadoSolicitud'])
            ->where('id_usuario', $usuario->id_usuario)
            ->latest('id_solicitud')
            ->limit(10)
            ->get();

        $multasPendientes = Multa::with(['prestamo.recurso'])
            ->where('id_usuario', $usuario->id_usuario)
            ->where('pagada', false)
            ->where('activo', true)
            ->latest('id_multa')
            ->get();

        $prestamosPorVencer = Prestamo::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->whereNull('fecha_devolucion')
            ->whereDate('fecha_vencimiento', '>=', today())
            ->whereDate('fecha_vencimiento', '<=', today()->addDays(2))
            ->count();

        $prestamosVencidos = Prestamo::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->whereNull('fecha_devolucion')
            ->whereDate('fecha_vencimiento', '<', today())
            ->count();

        $multasPendientesCantidad = Multa::query()
            ->where('id_usuario', $usuario->id_usuario)
            ->where('pagada', false)
            ->count();

        return view('bib.perfil.index', compact(
            'usuario',
            'prestamosActivos',
            'historialPrestamos',
            'solicitudes',
            'multasPendientes',
            'prestamosPorVencer',
            'prestamosVencidos',
            'multasPendientesCantidad',
        ));
    }
}