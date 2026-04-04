<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\TipoAcceso;
use App\Modules\Bib\Requests\StoreTipoAccesoRequest;
use App\Modules\Bib\Requests\UpdateTipoAccesoRequest;

class TipoAccesoController extends Controller
{
    public function index()
    {
        $items = TipoAcceso::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.tipos-acceso.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.tipos-acceso.create');
    }

    public function store(StoreTipoAccesoRequest $request)
    {
        TipoAcceso::create($request->validated());

        return redirect()
            ->route('bib.config.tipos-acceso.index')
            ->with('success', 'Tipo de acceso creado correctamente.');
    }

    public function edit(TipoAcceso $tipoAcceso)
    {
        return view('bib.config.tipos-acceso.edit', compact('tipoAcceso'));
    }

    public function update(UpdateTipoAccesoRequest $request, TipoAcceso $tipoAcceso)
    {
        $tipoAcceso->update($request->validated());

        return redirect()
            ->route('bib.config.tipos-acceso.index')
            ->with('success', 'Tipo de acceso actualizado correctamente.');
    }
}