<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Disponibilidad;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\EstadoPrestamo;
use App\Modules\Bib\Models\HistorialPrestamo;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\PoliticaPrestamo;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use App\Modules\Bib\Requests\StorePrestamoRequest;
use App\Modules\Bib\Requests\UpdatePrestamoRequest;
use App\Modules\Bib\Services\CirculacionService;
use App\Modules\Bib\Services\NotificacionBibliotecaService;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        if ($request->filled('estado')) {
            $codigoEstado = strtoupper(trim($request->estado));
            $query->whereHas('estadoPrestamo', function ($q) use ($codigoEstado) {
                $q->where('codigo', $codigoEstado);
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

        $usuario = Usuario::query()->findOrFail($data['id_usuario']);
        $recurso = Recurso::query()->findOrFail($data['id_recurso']);
        $ejemplar = Ejemplar::query()
            ->with(['disponibilidad', 'estado'])
            ->findOrFail($data['id_ejemplar']);

        try {
            app(CirculacionService::class)->validarUsuarioPuedePrestar($usuario, $recurso);
            app(CirculacionService::class)->validarEjemplarPuedePrestar($ejemplar);
        } catch (\RuntimeException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        $politica = PoliticaPrestamo::query()
            ->where('id_tipo_recurso', $recurso->id_tipo_recurso)
            ->first();

        if ($politica) {
            $data['dias_autorizados'] = $politica->dias_prestamo;
            $data['renovaciones_maximas'] = $politica->max_renovaciones;
            $data['multa_diaria'] = $politica->multa_diaria;
            $data['fecha_vencimiento'] = now()->addDays((int) $politica->dias_prestamo)->toDateString();
        }

        $prestamo = DB::transaction(function () use ($data, $ejemplar) {
            $estadoEntregado = $this->estadoPorCodigo('ENTREGADO');
            $disponibilidadPrestado = $this->disponibilidadPorCodigo('PRESTADO');

            $data['id_estado_prestamo'] = $estadoEntregado->id_estado_prestamo;
            $data['fecha_prestamo'] = $data['fecha_prestamo'] ?? now()->toDateString();
            $data['fecha_devolucion'] = null;
            $data['id_usuario_entrega'] = auth()->id();
            $data['id_usuario_recibe'] = null;
            $data['renovaciones_usadas'] = 0;
            $data['multa_acumulada'] = 0;
            $data['activo'] = true;

            $prestamo = Prestamo::create($data);

            $ejemplarBloqueado = Ejemplar::query()
                ->lockForUpdate()
                ->findOrFail($ejemplar->id_ejemplar);

            $ejemplarBloqueado->update([
                'id_disponibilidad' => $disponibilidadPrestado->id_disponibilidad,
            ]);

            $prestamo->load('recurso');

            $this->registrarHistorial(
                $prestamo,
                'CREACION',
                'Registro administrativo del préstamo directo desde mostrador.'
            );

            $this->registrarHistorial(
                $prestamo,
                'ENTREGA',
                'Préstamo directo entregado inmediatamente desde mostrador.'
            );

            app(NotificacionBibliotecaService::class)->crearParaUsuario(
                $prestamo->id_usuario,
                'PRESTAMO_ENTREGADO',
                'Préstamo entregado',
                'Se ha registrado y entregado tu préstamo del recurso "' .
                    ($prestamo->recurso?->titulo ?? 'N/D') .
                    '". Fecha de vencimiento: ' .
                    optional($prestamo->fecha_vencimiento)->format('d/m/Y') . '.',
                $prestamo->id_prestamo
            );

            return $prestamo;
        });

        return redirect()
            ->route('bib.prestamos.edit', $prestamo)
            ->with('success', 'Préstamo directo registrado y entregado correctamente.');
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
        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'No puedes actualizar un préstamo ya devuelto.');
        }

        $data = $request->validated();

        unset(
            $data['id_estado_prestamo'],
            $data['fecha_vencimiento'],
            $data['fecha_devolucion'],
            $data['id_usuario_entrega'],
            $data['id_usuario_recibe'],
            $data['dias_autorizados'],
            $data['renovaciones_usadas'],
            $data['renovaciones_maximas'],
            $data['multa_diaria'],
            $data['multa_acumulada'],
            $data['activo']
        );

        $prestamo->update($data);
        $prestamo->refresh();

        $this->registrarHistorial(
            $prestamo,
            'ACTUALIZACION',
            'Actualización administrativa del préstamo.'
        );

        return redirect()
            ->route('bib.prestamos.edit', $prestamo)
            ->with('success', 'Préstamo actualizado correctamente.');
    }

    public function devolver(Prestamo $prestamo)
    {
        $estadoEntregado = $this->estadoPorCodigo('ENTREGADO');
        $estadoVencido = $this->estadoPorCodigo('VENCIDO');

        if (!in_array((int) $prestamo->id_estado_prestamo, [
            (int) $estadoEntregado->id_estado_prestamo,
            (int) $estadoVencido->id_estado_prestamo,
        ], true)) {
            return back()->with('error', 'Solo puedes devolver préstamos entregados o vencidos.');
        }

        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'El préstamo ya fue devuelto.');
        }

        DB::transaction(function () use ($prestamo) {
            $estadoDevuelto = $this->estadoPorCodigo('DEVUELTO');
            $disponible = $this->disponibilidadPorCodigo('DISPONIBLE');

            $fechaHoy = now()->startOfDay();
            $diasAtraso = 0;

            if ($prestamo->fecha_vencimiento && $fechaHoy->gt($prestamo->fecha_vencimiento->copy()->startOfDay())) {
                $diasAtraso = $prestamo->fecha_vencimiento->copy()->startOfDay()->diffInDays($fechaHoy);
            }

            $prestamo->update([
                'id_estado_prestamo' => $estadoDevuelto->id_estado_prestamo,
                'fecha_devolucion' => $fechaHoy->toDateString(),
                'id_usuario_recibe' => auth()->id(),
            ]);

            if ($prestamo->ejemplar) {
                $prestamo->ejemplar->update([
                    'id_disponibilidad' => $disponible->id_disponibilidad,
                ]);
            }

            if ($diasAtraso > 0) {
                Multa::create([
                    'id_prestamo' => $prestamo->id_prestamo,
                    'id_usuario' => $prestamo->id_usuario,
                    'id_usuario_registra' => auth()->id(),
                    'fecha_multa' => $fechaHoy->toDateString(),
                    'dias_atraso' => $diasAtraso,
                    'monto' => $diasAtraso * (float) $prestamo->multa_diaria,
                    'monto_pagado' => 0,
                    'pagada' => false,
                    'motivo' => 'Devolución con atraso',
                    'activo' => true,
                ]);
            }

            $this->recalcularMulta($prestamo);

            $prestamo->refresh();

            $this->registrarHistorial(
                $prestamo,
                'DEVOLUCION',
                $diasAtraso > 0
                    ? "Devolución con {$diasAtraso} días de atraso."
                    : 'Devolución sin atraso.'
            );

            app(NotificacionBibliotecaService::class)->crearParaUsuario(
                $prestamo->id_usuario,
                'PRESTAMO_DEVUELTO',
                'Préstamo devuelto',
                $diasAtraso > 0
                    ? 'Tu préstamo del recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '" fue devuelto con ' . $diasAtraso . ' día(s) de atraso.'
                    : 'Tu préstamo del recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '" fue devuelto correctamente.',
                $prestamo->id_prestamo
            );
        });

        return redirect()
            ->route('bib.prestamos.edit', $prestamo)
            ->with('success', 'Devolución registrada correctamente.');
    }

    public function entregar(Prestamo $prestamo)
    {
        $estadoPendiente = $this->estadoPorCodigo('PENDIENTE_ENTREGA');

        if ((int) $prestamo->id_estado_prestamo !== (int) $estadoPendiente->id_estado_prestamo) {
            return back()->with('error', 'Solo puedes entregar préstamos pendientes de entrega.');
        }

        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'No puedes entregar un préstamo ya devuelto.');
        }

        if ($prestamo->ejemplar === null) {
            return back()->with('error', 'El préstamo no tiene un ejemplar asociado.');
        }

        try {
            DB::transaction(function () use ($prestamo) {
                $estadoEntregado = $this->estadoPorCodigo('ENTREGADO');
                $disponibilidadPrestado = $this->disponibilidadPorCodigo('PRESTADO');
                $disponibilidadDisponible = $this->disponibilidadPorCodigo('DISPONIBLE');
                $disponibilidadReservado = $this->disponibilidadPorCodigo('RESERVADO');

                $ejemplar = $prestamo->ejemplar()->lockForUpdate()->first();

                if (!$ejemplar) {
                    abort(404, 'No se encontró el ejemplar asociado al préstamo.');
                }

                if (!in_array((int) $ejemplar->id_disponibilidad, [
                    (int) $disponibilidadDisponible->id_disponibilidad,
                    (int) $disponibilidadReservado->id_disponibilidad,
                ], true)) {
                    throw new \RuntimeException('El ejemplar no está disponible o reservado para este préstamo.');
                }

                $prestamo->update([
                    'id_estado_prestamo' => $estadoEntregado->id_estado_prestamo,
                    'fecha_prestamo' => now()->toDateString(),
                    'id_usuario_entrega' => auth()->id(),
                ]);

                $ejemplar->update([
                    'id_disponibilidad' => $disponibilidadPrestado->id_disponibilidad,
                ]);

                $prestamo->refresh();

                $this->registrarHistorial(
                    $prestamo,
                    'ENTREGA',
                    'Entrega del ejemplar al usuario y salida efectiva de circulación.'
                );

                app(NotificacionBibliotecaService::class)->crearParaUsuario(
                    $prestamo->id_usuario,
                    'PRESTAMO_ENTREGADO',
                    'Préstamo entregado',
                    'Ya fue entregado el recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '". Fecha de vencimiento: ' . optional($prestamo->fecha_vencimiento)->format('d/m/Y') . '.',
                    $prestamo->id_prestamo
                );
            });
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('bib.prestamos.edit', $prestamo)
            ->with('success', 'Préstamo entregado correctamente.');
    }

    public function renovar(Prestamo $prestamo)
    {
        $estadoEntregado = $this->estadoPorCodigo('ENTREGADO');

        if ((int) $prestamo->id_estado_prestamo !== (int) $estadoEntregado->id_estado_prestamo) {
            return back()->with('error', 'Solo puedes renovar préstamos entregados.');
        }

        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'No puedes renovar un préstamo ya devuelto.');
        }

        if ((int) $prestamo->renovaciones_usadas >= (int) $prestamo->renovaciones_maximas) {
            return back()->with('error', 'Este préstamo ya alcanzó el máximo de renovaciones permitidas.');
        }

        $prestamo->loadMissing('usuario');

        try {
            app(CirculacionService::class)->validarUsuarioPuedeRenovar($prestamo->usuario);
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        DB::transaction(function () use ($prestamo) {
            $dias = max((int) $prestamo->dias_autorizados, 1);

            $prestamo->update([
                'fecha_vencimiento' => $prestamo->fecha_vencimiento
                    ? $prestamo->fecha_vencimiento->copy()->addDays($dias)->toDateString()
                    : now()->addDays($dias)->toDateString(),
                'renovaciones_usadas' => ((int) $prestamo->renovaciones_usadas) + 1,
            ]);

            $prestamo->refresh();

            $this->registrarHistorial(
                $prestamo,
                'RENOVACION',
                'Renovación del préstamo por ' . $dias . ' días adicionales.'
            );

            app(NotificacionBibliotecaService::class)->crearParaUsuario(
                $prestamo->id_usuario,
                'PRESTAMO_RENOVADO',
                'Préstamo renovado',
                'Tu préstamo del recurso "' . ($prestamo->recurso?->titulo ?? 'N/D') . '" fue renovado. Nueva fecha de vencimiento: ' . optional($prestamo->fecha_vencimiento)->format('d/m/Y') . '.',
                $prestamo->id_prestamo
            );
        });

        return redirect()
            ->route('bib.prestamos.edit', $prestamo)
            ->with('success', 'Préstamo renovado correctamente.');
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