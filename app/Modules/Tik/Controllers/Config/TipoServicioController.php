<?php

namespace App\Modules\Tik\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\TipoServicio;
use App\Modules\Org\Models\Area;
use Illuminate\Http\Request;

class TipoServicioController extends Controller
{
    public function index()
    {
        $tiposServicio = TipoServicio::query()
            ->with('areaResponsable:id_area,nombre')
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('tik.config.tipos-servicio.index', compact('tiposServicio'));
    }

    public function create()
    {
        $areas = Area::query()
            ->orderBy('nombre')
            ->get();

        return view('tik.config.tipos-servicio.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_tipos_servicio,codigo'],
            'nombre' => ['required', 'string', 'max:255'],
            'id_area_responsable' => ['nullable', 'integer', 'exists:org_areas,id_area'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        TipoServicio::create($data);

        return redirect()
            ->route('tik.config.tipos-servicio.index')
            ->with('success', 'Tipo de servicio creado correctamente.');
    }

    public function edit(TipoServicio $tipoServicio)
    {
        $areas = Area::query()
            ->orderBy('nombre')
            ->get();

        return view('tik.config.tipos-servicio.edit', compact('tipoServicio', 'areas'));
    }

    public function update(Request $request, TipoServicio $tipoServicio)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_tipos_servicio,codigo,' . $tipoServicio->id_tipo_servicio . ',id_tipo_servicio'],
            'nombre' => ['required', 'string', 'max:255'],
            'id_area_responsable' => ['nullable', 'integer', 'exists:org_areas,id_area'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        $tipoServicio->update($data);

        return redirect()
            ->route('tik.config.tipos-servicio.index')
            ->with('success', 'Tipo de servicio actualizado correctamente.');
    }
}