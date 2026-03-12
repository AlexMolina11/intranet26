<?php

namespace App\Modules\Org\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Org\Models\Proyecto;
use App\Modules\Org\Requests\StoreProyectoRequest;
use App\Modules\Org\Requests\UpdateProyectoRequest;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::orderBy('id_proyecto', 'desc')->paginate(10);

        return view('org.proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        return view('org.proyectos.create');
    }

    public function store(StoreProyectoRequest $request)
    {
        Proyecto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? true,
        ]);

        return redirect()
            ->route('org.proyectos.index')
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function edit(Proyecto $proyecto)
    {
        return view('org.proyectos.edit', compact('proyecto'));
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto)
    {
        $proyecto->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? false,
        ]);

        return redirect()
            ->route('org.proyectos.index')
            ->with('success', 'Proyecto actualizado correctamente.');
    }
}