<?php

namespace App\Modules\Tik\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Servicio;
use App\Modules\Tik\Models\TipoServicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::query()
            ->with('tipoServicio:id_tipo_servicio,nombre')
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('tik.config.servicios.index', compact('servicios'));
    }

    public function create()
    {
        $tiposServicio = TipoServicio::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('tik.config.servicios.create', compact('tiposServicio'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tipo_servicio' => ['required', 'integer', 'exists:tik_tipos_servicio,id_tipo_servicio'],
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_servicios,codigo'],
            'nombre' => ['required', 'string', 'max:255'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        Servicio::create($data);

        return redirect()
            ->route('tik.config.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Servicio $servicio)
    {
        $tiposServicio = TipoServicio::query()
            ->orderBy('nombre')
            ->get();

        return view('tik.config.servicios.edit', compact('servicio', 'tiposServicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'id_tipo_servicio' => ['required', 'integer', 'exists:tik_tipos_servicio,id_tipo_servicio'],
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_servicios,codigo,' . $servicio->id_servicio . ',id_servicio'],
            'nombre' => ['required', 'string', 'max:255'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        $servicio->update($data);

        return redirect()
            ->route('tik.config.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }
}