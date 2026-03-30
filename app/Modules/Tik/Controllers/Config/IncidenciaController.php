<?php

namespace App\Modules\Tik\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Incidencia;
use App\Modules\Org\Models\Area;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::query()
            ->with('areaResponsable:id_area,nombre')
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('tik.config.incidencias.index', compact('incidencias'));
    }

    public function create()
    {
        $areas = Area::query()
            ->orderBy('nombre')
            ->get();

        return view('tik.config.incidencias.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_incidencias,codigo'],
            'nombre' => ['required', 'string', 'max:255'],
            'id_area_responsable' => ['nullable', 'integer', 'exists:org_areas,id_area'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        Incidencia::create($data);

        return redirect()
            ->route('tik.config.incidencias.index')
            ->with('success', 'Incidencia creada correctamente.');
    }

    public function edit(Incidencia $incidencia)
    {
        $areas = Area::query()
            ->orderBy('nombre')
            ->get();

        return view('tik.config.incidencias.edit', compact('incidencia', 'areas'));
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_incidencias,codigo,' . $incidencia->id_incidencia . ',id_incidencia'],
            'nombre' => ['required', 'string', 'max:255'],
            'id_area_responsable' => ['nullable', 'integer', 'exists:org_areas,id_area'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        $incidencia->update($data);

        return redirect()
            ->route('tik.config.incidencias.index')
            ->with('success', 'Incidencia actualizada correctamente.');
    }
}