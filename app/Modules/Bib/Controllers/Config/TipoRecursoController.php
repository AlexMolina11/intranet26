<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\TipoRecurso;
use App\Modules\Bib\Requests\StoreTipoRecursoRequest;
use App\Modules\Bib\Requests\UpdateTipoRecursoRequest;

class TipoRecursoController extends Controller
{
    public function index()
    {
        $items = TipoRecurso::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.tipos-recurso.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.tipos-recurso.create');
    }

    public function store(StoreTipoRecursoRequest $request)
    {
        TipoRecurso::create($request->validated());

        return redirect()
            ->route('bib.config.tipos-recurso.index')
            ->with('success', 'Tipo de recurso creado correctamente.');
    }

    public function edit(TipoRecurso $tipoRecurso)
    {
        return view('bib.config.tipos-recurso.edit', compact('tipoRecurso'));
    }

    public function update(UpdateTipoRecursoRequest $request, TipoRecurso $tipoRecurso)
    {
        $tipoRecurso->update($request->validated());

        return redirect()
            ->route('bib.config.tipos-recurso.index')
            ->with('success', 'Tipo de recurso actualizado correctamente.');
    }
}