<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\PoliticaPrestamo;
use App\Modules\Bib\Models\TipoRecurso;
use App\Modules\Bib\Requests\StorePoliticaPrestamoRequest;
use App\Modules\Bib\Requests\UpdatePoliticaPrestamoRequest;
use Illuminate\Http\Request;

class PoliticaPrestamoController extends Controller
{
    public function index(Request $request)
    {
        $query = PoliticaPrestamo::query()
            ->with('tipoRecurso');

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->whereHas('tipoRecurso', function ($subquery) use ($search) {
                $subquery->where('codigo', 'like', "%{$search}%")
                    ->orWhere('nombre', 'like', "%{$search}%");
            });
        }

        if ($request->filled('activo') && $request->activo !== '') {
            $query->where('activo', (bool) $request->activo);
        }

        $politicas = $query
            ->orderBy('orden')
            ->orderBy('id_politica_prestamo')
            ->paginate(15)
            ->withQueryString();

        return view('bib.politicas.index', compact('politicas'));
    }

    public function create()
    {
        $tiposRecurso = TipoRecurso::query()
            ->where('activo', true)
            ->whereNotIn(
                'id_tipo_recurso',
                PoliticaPrestamo::query()->pluck('id_tipo_recurso')
            )
            ->orderBy('nombre')
            ->get();

        return view('bib.politicas.create', compact('tiposRecurso'));
    }

    public function store(StorePoliticaPrestamoRequest $request)
    {
        PoliticaPrestamo::create($request->validated());

        return redirect()
            ->route('bib.politicas.index')
            ->with('success', 'Política de préstamo creada correctamente.');
    }

    public function edit(PoliticaPrestamo $politica)
    {
        $tiposRecurso = TipoRecurso::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('bib.politicas.edit', compact('politica', 'tiposRecurso'));
    }

    public function update(UpdatePoliticaPrestamoRequest $request, PoliticaPrestamo $politica)
    {
        $politica->update($request->validated());

        return redirect()
            ->route('bib.politicas.index')
            ->with('success', 'Política de préstamo actualizada correctamente.');
    }
}