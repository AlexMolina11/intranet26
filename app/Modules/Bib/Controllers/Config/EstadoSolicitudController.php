<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\EstadoSolicitud;
use App\Modules\Bib\Requests\StoreEstadoSolicitudRequest;
use App\Modules\Bib\Requests\UpdateEstadoSolicitudRequest;

class EstadoSolicitudController extends Controller
{
    public function index()
    {
        $items = EstadoSolicitud::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.estados-solicitud.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.estados-solicitud.create');
    }

    public function store(StoreEstadoSolicitudRequest $request)
    {
        EstadoSolicitud::create($request->validated());

        return redirect()
            ->route('bib.config.estados-solicitud.index')
            ->with('success', 'Estado de solicitud creado correctamente.');
    }

    public function edit(EstadoSolicitud $estadoSolicitud)
    {
        return view('bib.config.estados-solicitud.edit', compact('estadoSolicitud'));
    }

    public function update(UpdateEstadoSolicitudRequest $request, EstadoSolicitud $estadoSolicitud)
    {
        $estadoSolicitud->update($request->validated());

        return redirect()
            ->route('bib.config.estados-solicitud.index')
            ->with('success', 'Estado de solicitud actualizado correctamente.');
    }
}