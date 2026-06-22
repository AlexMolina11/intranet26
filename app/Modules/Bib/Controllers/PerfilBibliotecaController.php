<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Solicitud;
use Illuminate\Http\Request;
use App\Modules\Bib\Controllers\PrestamoController;

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

    public function renovar(Prestamo $prestamo)
    {
        if ((int) $prestamo->id_usuario !== (int) auth()->user()->id_usuario) {
            abort(403, 'No puedes renovar préstamos de otro usuario.');
        }

        $estadoEntregado = \App\Modules\Bib\Models\EstadoPrestamo::where('codigo', 'ENTREGADO')->firstOrFail();

        if ((int) $prestamo->id_estado_prestamo !== (int) $estadoEntregado->id_estado_prestamo) {
            return redirect()
                ->route('bib.perfil')
                ->with('error', 'Solo puedes renovar préstamos entregados.');
        }

        if ($prestamo->fecha_devolucion) {
            return redirect()
                ->route('bib.perfil')
                ->with('error', 'No puedes renovar un préstamo ya devuelto.');
        }

        if ((int) $prestamo->renovaciones_usadas >= (int) $prestamo->renovaciones_maximas) {
            return redirect()
                ->route('bib.perfil')
                ->with('error', 'Este préstamo ya alcanzó el máximo de renovaciones permitidas.');
        }

        try {
            app(\App\Modules\Bib\Services\CirculacionService::class)
                ->validarUsuarioPuedeRenovar(auth()->user());
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('bib.perfil')
                ->with('error', $exception->getMessage());
        }

        \DB::transaction(function () use ($prestamo) {
            $dias = max((int) $prestamo->dias_autorizados, 1);

            $fechaBase = $prestamo->fecha_vencimiento
                ? \Carbon\Carbon::parse($prestamo->fecha_vencimiento)
                : now();

            $prestamo->update([
                'fecha_vencimiento' => $fechaBase->addDays($dias)->toDateString(),
                'renovaciones_usadas' => ((int) $prestamo->renovaciones_usadas) + 1,
            ]);

            app(\App\Modules\Bib\Services\NotificacionBibliotecaService::class)->crearParaUsuario(
                $prestamo->id_usuario,
                'PRESTAMO_RENOVADO',
                'Préstamo renovado',
                'Tu préstamo del recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '" fue renovado correctamente.',
                $prestamo->id_prestamo
            );
        });

        return redirect()
            ->route('bib.perfil')
            ->with('success', 'Préstamo renovado correctamente.');
    }
}