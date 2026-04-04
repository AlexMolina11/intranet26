<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Disponibilidad;
use App\Modules\Bib\Requests\StoreDisponibilidadRequest;
use App\Modules\Bib\Requests\UpdateDisponibilidadRequest;

class DisponibilidadController extends Controller
{
    public function index()
    {
        $items = Disponibilidad::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.disponibilidades.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.disponibilidades.create');
    }

    public function store(StoreDisponibilidadRequest $request)
    {
        Disponibilidad::create($request->validated());

        return redirect()
            ->route('bib.config.disponibilidades.index')
            ->with('success', 'Disponibilidad creada correctamente.');
    }

    public function edit(Disponibilidad $disponibilidad)
    {
        return view('bib.config.disponibilidades.edit', compact('disponibilidad'));
    }

    public function update(UpdateDisponibilidadRequest $request, Disponibilidad $disponibilidad)
    {
        $disponibilidad->update($request->validated());

        return redirect()
            ->route('bib.config.disponibilidades.index')
            ->with('success', 'Disponibilidad actualizada correctamente.');
    }
}