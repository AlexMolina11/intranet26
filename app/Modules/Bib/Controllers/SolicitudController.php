<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Disponibilidad;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\EstadoPrestamo;
use App\Modules\Bib\Models\EstadoSolicitud;
use App\Modules\Bib\Models\HistorialPrestamo;
use App\Modules\Bib\Models\PoliticaPrestamo;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use App\Modules\Bib\Requests\StoreSolicitudRequest;
use App\Modules\Bib\Requests\UpdateSolicitudRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Bib\Services\CirculacionService;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $query = Solicitud::query()
            ->with([
                'usuario',
                'recurso',
                'ejemplar',
                'estadoSolicitud',
                'usuarioAtiende',
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
                })->orWhere('motivo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('id_estado_solicitud')) {
            $query->where('id_estado_solicitud', (int) $request->id_estado_solicitud);
        }

        if ($request->filled('activo') && $request->activo !== '') {
            $query->where('activo', (bool) $request->activo);
        }

        $solicitudes = $query
            ->latest('id_solicitud')
            ->paginate(15)
            ->withQueryString();

        $estadosSolicitud = EstadoSolicitud::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('bib.solicitudes.index', compact('solicitudes', 'estadosSolicitud'));
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

        $estadosSolicitud = EstadoSolicitud::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('bib.solicitudes.create', compact(
            'usuarios',
            'recursos',
            'ejemplares',
            'estadosSolicitud'
        ));
    }

    public function store(StoreSolicitudRequest $request)
    {
        $data = $request->validated();

        if (empty($data['id_estado_solicitud'])) {
            $data['id_estado_solicitud'] = $this->estadoSolicitudPorCodigo('PENDIENTE')->id_estado_solicitud;
        }

        Solicitud::create($data);

        return redirect()
            ->route('bib.solicitudes.index')
            ->with('success', 'Solicitud registrada correctamente.');
    }

    public function edit(Solicitud $solicitud)
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
            ->with(['recurso', 'disponibilidad'])
            ->where('activo', true)
            ->orderBy('codigo_inventario')
            ->get();

        $estadosSolicitud = EstadoSolicitud::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('bib.solicitudes.edit', [
            'solicitud' => $solicitud->load(['usuario', 'recurso', 'ejemplar', 'estadoSolicitud', 'usuarioAtiende']),
            'usuarios' => $usuarios,
            'recursos' => $recursos,
            'ejemplares' => $ejemplares,
            'estadosSolicitud' => $estadosSolicitud,
        ]);
    }

    public function update(UpdateSolicitudRequest $request, Solicitud $solicitud)
    {
        if (in_array($solicitud->estadoSolicitud?->codigo, ['ATENDIDA', 'RECHAZADA'], true)) {
            return back()->with('error', 'No puedes actualizar una solicitud finalizada.');
        }

        $solicitud->update($request->validated());

        return redirect()
            ->route('bib.solicitudes.edit', $solicitud)
            ->with('success', 'Solicitud actualizada correctamente.');
    }

    public function aprobar(Solicitud $solicitud)
    {
        if ($solicitud->estadoSolicitud?->codigo !== 'PENDIENTE') {
            return back()->with('error', 'Solo puedes aprobar solicitudes pendientes.');
        }

        $solicitud->update([
            'id_estado_solicitud' => $this->estadoSolicitudPorCodigo('APROBADA')->id_estado_solicitud,
            'fecha_atencion' => now()->toDateString(),
            'id_usuario_atiende' => auth()->id(),
        ]);

        return redirect()
            ->route('bib.solicitudes.edit', $solicitud)
            ->with('success', 'Solicitud aprobada correctamente. Ahora puedes generar el préstamo.');
    }

    public function rechazar(Solicitud $solicitud)
    {
        if (in_array($solicitud->estadoSolicitud?->codigo, ['ATENDIDA', 'RECHAZADA'], true)) {
            return back()->with('error', 'Esta solicitud ya está finalizada.');
        }

        $solicitud->update([
            'id_estado_solicitud' => $this->estadoSolicitudPorCodigo('RECHAZADA')->id_estado_solicitud,
            'fecha_atencion' => now()->toDateString(),
            'id_usuario_atiende' => auth()->id(),
        ]);

        return redirect()
            ->route('bib.solicitudes.edit', $solicitud)
            ->with('success', 'Solicitud rechazada correctamente.');
    }

    public function generarPrestamo(Solicitud $solicitud)
    {
        if ($solicitud->estadoSolicitud?->codigo !== 'APROBADA') {
            return back()->with('error', 'Solo puedes generar préstamo desde solicitudes aprobadas.');
        }

        if (!$solicitud->id_ejemplar) {
            return back()->with('error', 'Debes seleccionar un ejemplar antes de generar el préstamo.');
        }

        try {
            DB::transaction(function () use ($solicitud) {
                $ejemplar = Ejemplar::query()
                    ->with('disponibilidad')
                    ->lockForUpdate()
                    ->findOrFail($solicitud->id_ejemplar);

                $disponible = Disponibilidad::query()
                    ->where('codigo', 'DISPONIBLE')
                    ->firstOrFail();

                if ((int) $ejemplar->id_disponibilidad !== (int) $disponible->id_disponibilidad) {
                    throw new \RuntimeException('El ejemplar seleccionado no está disponible.');
                }

                $recurso = Recurso::query()->findOrFail($solicitud->id_recurso);
                $usuario = Usuario::query()->findOrFail($solicitud->id_usuario);

                app(CirculacionService::class)->validarUsuarioPuedePrestar($usuario, $recurso);
                app(CirculacionService::class)->validarEjemplarPuedePrestar($ejemplar);

                $estadoPendienteEntrega = EstadoPrestamo::query()
                    ->where('codigo', 'PENDIENTE_ENTREGA')
                    ->firstOrFail();

                $politica = PoliticaPrestamo::query()
                    ->where('id_tipo_recurso', $recurso->id_tipo_recurso)
                    ->where('activo', true)
                    ->first();

                $diasAutorizados = $politica?->dias_prestamo ?? 8;
                $renovacionesMaximas = $politica?->max_renovaciones ?? 1;
                $multaDiaria = $politica?->multa_diaria ?? 0;

                $prestamo = Prestamo::create([
                    'id_usuario' => $solicitud->id_usuario,
                    'id_recurso' => $solicitud->id_recurso,
                    'id_ejemplar' => $solicitud->id_ejemplar,
                    'id_estado_prestamo' => $estadoPendienteEntrega->id_estado_prestamo,
                    'fecha_prestamo' => now()->toDateString(),
                    'fecha_vencimiento' => now()->addDays((int) $diasAutorizados)->toDateString(),
                    'fecha_devolucion' => null,
                    'dias_autorizados' => $diasAutorizados,
                    'renovaciones_usadas' => 0,
                    'renovaciones_maximas' => $renovacionesMaximas,
                    'multa_diaria' => $multaDiaria,
                    'multa_acumulada' => 0,
                    'id_usuario_entrega' => null,
                    'id_usuario_recibe' => null,
                    'activo' => true,
                ]);

                HistorialPrestamo::create([
                    'id_prestamo' => $prestamo->id_prestamo,
                    'id_estado_prestamo' => $prestamo->id_estado_prestamo,
                    'id_usuario_accion' => auth()->id(),
                    'tipo_movimiento' => 'CREACION',
                    'fecha_movimiento' => now()->toDateString(),
                    'fecha_vencimiento' => $prestamo->fecha_vencimiento,
                    'fecha_devolucion' => null,
                    'multa_acumulada' => 0,
                    'observaciones' => 'Préstamo generado desde solicitud aprobada.',
                    'activo' => true,
                ]);

                $solicitud->update([
                    'id_estado_solicitud' => $this->estadoSolicitudPorCodigo('ATENDIDA')->id_estado_solicitud,
                    'fecha_atencion' => now()->toDateString(),
                    'id_usuario_atiende' => auth()->id(),
                    'observaciones_internas' => trim(($solicitud->observaciones_internas ?? '') . "\nPréstamo generado: #{$prestamo->id_prestamo}"),
                ]);
            });
        } catch (\RuntimeException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('bib.solicitudes.edit', $solicitud)
            ->with('success', 'Préstamo generado correctamente. La solicitud quedó atendida.');
    }

    private function estadoSolicitudPorCodigo(string $codigo): EstadoSolicitud
    {
        return EstadoSolicitud::query()
            ->where('codigo', $codigo)
            ->firstOrFail();
    }
}