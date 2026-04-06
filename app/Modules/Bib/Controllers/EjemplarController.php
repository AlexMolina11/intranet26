<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Disponibilidad;
use App\Modules\Bib\Models\Ejemplar;
use App\Modules\Bib\Models\EstadoEjemplar;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Requests\StoreEjemplarRequest;
use App\Modules\Bib\Requests\UpdateEjemplarRequest;
use Illuminate\Http\Request;

class EjemplarController extends Controller
{
    public function index(Request $request)
    {
        $query = Ejemplar::query()
            ->with(['recurso', 'estado', 'disponibilidad']);

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($subquery) use ($search) {
                $subquery->where('codigo_inventario', 'like', "%{$search}%")
                    ->orWhere('codigo_barras', 'like', "%{$search}%")
                    ->orWhere('ubicacion', 'like', "%{$search}%")
                    ->orWhereHas('recurso', function ($recursoQuery) use ($search) {
                        $recursoQuery->where('titulo', 'like', "%{$search}%")
                            ->orWhere('codigo', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('id_recurso')) {
            $query->where('id_recurso', (int) $request->id_recurso);
        }

        if ($request->filled('id_estado_ejemplar')) {
            $query->where('id_estado_ejemplar', (int) $request->id_estado_ejemplar);
        }

        if ($request->filled('id_disponibilidad')) {
            $query->where('id_disponibilidad', (int) $request->id_disponibilidad);
        }

        if ($request->filled('activo') && $request->activo !== '') {
            $query->where('activo', (bool) $request->activo);
        }

        $ejemplares = $query
            ->latest('id_ejemplar')
            ->paginate(15)
            ->withQueryString();

        $recursos = Recurso::query()
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        $estados = EstadoEjemplar::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $disponibilidades = Disponibilidad::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('bib.ejemplares.index', compact('ejemplares', 'recursos', 'estados', 'disponibilidades'));
    }

    public function create()
    {
        return view('bib.ejemplares.create', [
            'recursos' => Recurso::query()->where('activo', true)->orderBy('titulo')->get(),
            'estados' => EstadoEjemplar::query()->where('activo', true)->orderBy('nombre')->get(),
            'disponibilidades' => Disponibilidad::query()->where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreEjemplarRequest $request)
    {
        Ejemplar::create($request->validated());

        return redirect()
            ->route('bib.ejemplares.index')
            ->with('success', 'Ejemplar creado correctamente.');
    }

    public function edit(Ejemplar $ejemplar)
    {
        return view('bib.ejemplares.edit', [
            'ejemplar' => $ejemplar,
            'recursos' => Recurso::query()->where('activo', true)->orderBy('titulo')->get(),
            'estados' => EstadoEjemplar::query()->where('activo', true)->orderBy('nombre')->get(),
            'disponibilidades' => Disponibilidad::query()->where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateEjemplarRequest $request, Ejemplar $ejemplar)
    {
        $ejemplar->update($request->validated());

        return redirect()
            ->route('bib.ejemplares.index')
            ->with('success', 'Ejemplar actualizado correctamente.');
    }
}