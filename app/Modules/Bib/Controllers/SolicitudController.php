<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\EstadoSolicitud;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\Solicitud;
use App\Modules\Bib\Requests\StoreSolicitudRequest;
use App\Modules\Bib\Requests\UpdateSolicitudRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;

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
                    $q->where('nombre', 'like', "%{$search}%")
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
            ->orderBy('nombre')
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
        Solicitud::create($request->validated());

        return redirect()
            ->route('bib.solicitudes.index')
            ->with('success', 'Solicitud registrada correctamente.');
    }

    public function edit(Solicitud $solicitude)
    {
        $usuarios = Usuario::query()
            ->where('activo', true)
            ->orderBy('nombre')
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

        return view('bib.solicitudes.edit', [
            'solicitud' => $solicitude,
            'usuarios' => $usuarios,
            'recursos' => $recursos,
            'ejemplares' => $ejemplares,
            'estadosSolicitud' => $estadosSolicitud,
        ]);
    }

    public function update(UpdateSolicitudRequest $request, Solicitud $solicitude)
    {
        $solicitude->update($request->validated());

        return redirect()
            ->route('bib.solicitudes.index')
            ->with('success', 'Solicitud actualizada correctamente.');
    }
}