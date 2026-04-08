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

        Prestamo::create($data);

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

        return redirect()
            ->route('bib.prestamos.index')
            ->with('success', 'Préstamo actualizado correctamente.');
    }
}