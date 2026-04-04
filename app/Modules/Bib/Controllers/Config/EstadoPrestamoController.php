<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\EstadoPrestamo;
use App\Modules\Bib\Requests\StoreEstadoPrestamoRequest;
use App\Modules\Bib\Requests\UpdateEstadoPrestamoRequest;

class EstadoPrestamoController extends Controller
{
    public function index()
    {
        $items = EstadoPrestamo::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.estados-prestamo.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.estados-prestamo.create');
    }

    public function store(StoreEstadoPrestamoRequest $request)
    {
        EstadoPrestamo::create($request->validated());

        return redirect()
            ->route('bib.config.estados-prestamo.index')
            ->with('success', 'Estado de préstamo creado correctamente.');
    }

    public function edit(EstadoPrestamo $estadoPrestamo)
    {
        return view('bib.config.estados-prestamo.edit', compact('estadoPrestamo'));
    }

    public function update(UpdateEstadoPrestamoRequest $request, EstadoPrestamo $estadoPrestamo)
    {
        $estadoPrestamo->update($request->validated());

        return redirect()
            ->route('bib.config.estados-prestamo.index')
            ->with('success', 'Estado de préstamo actualizado correctamente.');
    }
}