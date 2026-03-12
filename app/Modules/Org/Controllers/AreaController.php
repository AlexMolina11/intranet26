<?php

namespace App\Modules\Org\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Org\Models\Area;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Models\Proyecto;
use App\Modules\Org\Requests\StoreAreaRequest;
use App\Modules\Org\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::with(['departamento', 'proyecto'])
            ->orderBy('id_area', 'desc')
            ->paginate(10);

        return view('org.areas.index', compact('areas'));
    }

    public function create()
    {
        $departamentos = Departamento::where('activo', true)->orderBy('nombre')->get();
        $proyectos = Proyecto::where('activo', true)->orderBy('nombre')->get();

        return view('org.areas.create', compact('departamentos', 'proyectos'));
    }

    public function store(StoreAreaRequest $request)
    {
        Area::create([
            'id_departamento' => $request->id_departamento,
            'id_proyecto' => $request->id_proyecto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? true,
        ]);

        return redirect()
            ->route('org.areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        $departamentos = Departamento::where('activo', true)->orderBy('nombre')->get();
        $proyectos = Proyecto::where('activo', true)->orderBy('nombre')->get();

        return view('org.areas.edit', compact('area', 'departamentos', 'proyectos'));
    }

    public function update(UpdateAreaRequest $request, Area $area)
    {
        $area->update([
            'id_departamento' => $request->id_departamento,
            'id_proyecto' => $request->id_proyecto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? false,
        ]);

        return redirect()
            ->route('org.areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }
}