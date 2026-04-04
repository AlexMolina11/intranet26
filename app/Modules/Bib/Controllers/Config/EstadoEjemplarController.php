<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\EstadoEjemplar;
use App\Modules\Bib\Requests\StoreEstadoEjemplarRequest;
use App\Modules\Bib\Requests\UpdateEstadoEjemplarRequest;

class EstadoEjemplarController extends Controller
{
    public function index()
    {
        $items = EstadoEjemplar::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.estados-ejemplar.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.estados-ejemplar.create');
    }

    public function store(StoreEstadoEjemplarRequest $request)
    {
        EstadoEjemplar::create($request->validated());

        return redirect()
            ->route('bib.config.estados-ejemplar.index')
            ->with('success', 'Estado de ejemplar creado correctamente.');
    }

    public function edit(EstadoEjemplar $estadoEjemplar)
    {
        return view('bib.config.estados-ejemplar.edit', compact('estadoEjemplar'));
    }

    public function update(UpdateEstadoEjemplarRequest $request, EstadoEjemplar $estadoEjemplar)
    {
        $estadoEjemplar->update($request->validated());

        return redirect()
            ->route('bib.config.estados-ejemplar.index')
            ->with('success', 'Estado de ejemplar actualizado correctamente.');
    }
}