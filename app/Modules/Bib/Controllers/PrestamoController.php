<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\EstadoPrestamo;
use App\Modules\Bib\Models\PoliticaPrestamo;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use App\Modules\Bib\Requests\StorePrestamoRequest;
use App\Modules\Bib\Requests\UpdatePrestamoRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use App\Modules\Bib\Models\HistorialPrestamo;
use Illuminate\Support\Facades\Auth;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestamo::query()
            ->with([
                'usuario',
                'recurso',
                'ejemplar',
                'estadoPrestamo',
                'solicitud',
                'usuarioEntrega',
                'usuarioRecibe',
            ]);

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($subquery) use ($search) {
                $subquery->whereHas('usuario', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                        ->orWhere('apellidos', 'like', "%{$search}%")
                        ->orWhere('correo', 'like', "%{$search}%");
                })->orWhereHas('recurso', function ($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                        ->orWhere('codigo', 'like', "%{$search}%");
                })->orWhereHas('ejemplar', function ($q) use ($search) {
                    $q->where('codigo_inventario', 'like', "%{$search}%")
                        ->orWhere('codigo_barras', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('id_estado_prestamo')) {
            $query->where('id_estado_prestamo', (int) $request->id_estado_prestamo);
        }

        if ($request->filled('activo') && $request->activo !== '') {
            $query->where('activo', (bool) $request->activo);
        }

        $prestamos = $query
            ->latest('id_prestamo')
            ->paginate(15)
            ->withQueryString();

        $estadosPrestamo = EstadoPrestamo::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('bib.prestamos.index', compact('prestamos', 'estadosPrestamo'));
    }

    public function create()
    {
        $usuarios = Usuario::query()
            ->where('activo', true)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        $recursos = Recurso::query()
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        $ejemplares = Ejemplar::query()
            ->with('recurso')
            ->where('activo', true)
            ->orderBy('codigo_inventario')
            ->get();

        $estadosPrestamo = EstadoPrestamo::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $solicitudes = Solicitud::query()
            ->with(['usuario', 'recurso'])
            ->where('activo', true)
            ->latest('id_solicitud')
            ->get();

        return view('bib.prestamos.create', compact(
            'usuarios',
            'recursos',
            'ejemplares',
            'estadosPrestamo',
            'solicitudes'
        ));
    }

    public function store(StorePrestamoRequest $request)
    {
        $data = $request->validated();

        $recurso = Recurso::query()->find($data['id_recurso']);

        if ($recurso) {
            $politica = PoliticaPrestamo::query()
                ->where('id_tipo_recurso', $recurso->id_tipo_recurso)
                ->first();

            if ($politica) {
                $data['dias_autorizados'] = $politica->dias_prestamo;
                $data['renovaciones_maximas'] = $politica->max_renovaciones;
                $data['multa_diaria'] = $politica->multa_diaria;
            }
        }

        $prestamo = Prestamo::create($data);

        $this->registrarHistorial($prestamo, 'CREACION', 'Registro inicial del préstamo.');

        return redirect()
            ->route('bib.prestamos.index')
            ->with('success', 'Préstamo registrado correctamente.');
    }

    public function edit(Prestamo $prestamo)
    {
        $usuarios = Usuario::query()
            ->where('activo', true)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        $recursos = Recurso::query()
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        $ejemplares = Ejemplar::query()
            ->with('recurso')
            ->where('activo', true)
            ->orderBy('codigo_inventario')
            ->get();

        $estadosPrestamo = EstadoPrestamo::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $solicitudes = Solicitud::query()
            ->with(['usuario', 'recurso'])
            ->where('activo', true)
            ->latest('id_solicitud')
            ->get();

        $prestamo->load([
            'historial.usuarioAccion',
            'historial.estadoPrestamo',
        ]);

        return view('bib.prestamos.edit', compact(
            'prestamo',
            'usuarios',
            'recursos',
            'ejemplares',
            'estadosPrestamo',
            'solicitudes'
        ));
    }

    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo)
    {
        $prestamo->update($request->validated());

        $tipoMovimiento = 'ACTUALIZACION';

        if ($prestamo->fecha_devolucion) {
            $tipoMovimiento = 'DEVOLUCION';
        } elseif ($prestamo->renovaciones_usadas > 0) {
            $tipoMovimiento = 'RENOVACION';
        }

        $this->registrarHistorial($prestamo, $tipoMovimiento, 'Actualización del préstamo.');

        return redirect()
            ->route('bib.prestamos.index')
            ->with('success', 'Préstamo actualizado correctamente.');
    }

    private function registrarHistorial(Prestamo $prestamo, string $tipoMovimiento, ?string $observaciones = null): void
    {
        HistorialPrestamo::create([
            'id_prestamo' => $prestamo->id_prestamo,
            'id_estado_prestamo' => $prestamo->id_estado_prestamo,
            'id_usuario_accion' => Auth::id(),
            'tipo_movimiento' => $tipoMovimiento,
            'fecha_movimiento' => now()->toDateString(),
            'fecha_prestamo' => optional($prestamo->fecha_prestamo)?->format('Y-m-d'),
            'fecha_vencimiento' => optional($prestamo->fecha_vencimiento)?->format('Y-m-d'),
            'fecha_devolucion' => optional($prestamo->fecha_devolucion)?->format('Y-m-d'),
            'dias_autorizados' => $prestamo->dias_autorizados,
            'renovaciones_usadas' => $prestamo->renovaciones_usadas,
            'renovaciones_maximas' => $prestamo->renovaciones_maximas,
            'multa_diaria' => $prestamo->multa_diaria,
            'multa_acumulada' => $prestamo->multa_acumulada,
            'observaciones' => $observaciones ?? $prestamo->observaciones,
        ]);
    }

    public function devolver(Prestamo $prestamo)
    {
        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'El préstamo ya fue devuelto.');
        }

        DB::transaction(function () use ($prestamo) {

            $estadoDevuelto = $this->estadoPorCodigo('DEVUELTO');
            $disponible = $this->disponibilidadPorCodigo('DISPONIBLE');

            $fechaHoy = now()->startOfDay();
            $diasAtraso = 0;

            if ($prestamo->fecha_vencimiento && $fechaHoy->gt($prestamo->fecha_vencimiento->copy()->startOfDay())) {
                $diasAtraso = $prestamo->fecha_vencimiento->diffInDays($fechaHoy);
            }

            // 1. Actualizar préstamo
            $prestamo->update([
                'id_estado_prestamo' => $estadoDevuelto->id_estado_prestamo,
                'fecha_devolucion' => $fechaHoy,
                'id_usuario_recibe' => auth()->id(),
            ]);

            // 2. Liberar ejemplar
            if ($prestamo->ejemplar) {
                $prestamo->ejemplar->update([
                    'id_disponibilidad' => $disponible->id_disponibilidad,
                ]);
            }

            // 3. Generar multa
            if ($diasAtraso > 0) {
                $monto = $diasAtraso * (float) $prestamo->multa_diaria;

                Multa::create([
                    'id_prestamo' => $prestamo->id_prestamo,
                    'id_usuario' => $prestamo->id_usuario,
                    'id_usuario_registra' => auth()->id(),
                    'fecha_multa' => $fechaHoy,
                    'dias_atraso' => $diasAtraso,
                    'monto' => $monto,
                    'monto_pagado' => 0,
                    'pagada' => false,
                    'motivo' => 'Devolución con atraso',
                    'activo' => true,
                ]);
            }

            // 4. Recalcular multa acumulada
            $this->recalcularMulta($prestamo);

            // 5. Historial
            $this->registrarHistorial(
                $prestamo,
                'DEVOLUCION',
                $diasAtraso > 0
                    ? "Devolución con {$diasAtraso} días de atraso"
                    : "Devolución sin atraso"
            );
        });

        return redirect()
            ->route('bib.prestamos.edit', $prestamo)
            ->with('success', 'Devolución registrada correctamente.');
    }

    private function estadoPorCodigo(string $codigo)
    {
        return EstadoPrestamo::where('codigo', $codigo)
            ->where('activo', true)
            ->firstOrFail();
    }

    private function disponibilidadPorCodigo(string $codigo)
    {
        return Disponibilidad::where('codigo', $codigo)
            ->where('activo', true)
            ->firstOrFail();
    }

    private function recalcularMulta(Prestamo $prestamo)
    {
        $total = $prestamo->multas()
            ->where('activo', true)
            ->sum('monto');

        $prestamo->update([
            'multa_acumulada' => $total,
        ]);
    }
}