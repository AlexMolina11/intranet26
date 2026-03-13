<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Permiso;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Requests\StorePermisoRequest;
use App\Modules\Seg\Requests\UpdatePermisoRequest;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index(Request $request)
    {
        $sistemaId = $request->get('id_sistema');

        $sistemas = Sistema::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $permisos = Permiso::with('sistema')
            ->when($sistemaId, function ($query) use ($sistemaId) {
                $query->where('id_sistema', $sistemaId);
            })
            ->orderBy('codigo')
            ->paginate(10)
            ->withQueryString();

        return view('seg.permisos.index', compact('permisos', 'sistemas', 'sistemaId'));
    }

    public function create()
    {
        $sistemas = Sistema::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('seg.permisos.create', compact('sistemas'));
    }

    public function store(StorePermisoRequest $request)
    {
        Permiso::create($request->validated());

        return redirect()
            ->route('seg.permisos.index')
            ->with('success', 'Permiso creado correctamente.');
    }

    public function edit(Permiso $permiso)
    {
        $sistemas = Sistema::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('seg.permisos.edit', compact('permiso', 'sistemas'));
    }

    public function update(UpdatePermisoRequest $request, Permiso $permiso)
    {
        $permiso->update($request->validated());

        return redirect()
            ->route('seg.permisos.index')
            ->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permiso $permiso)
    {
        $permiso->delete();

        return redirect()
            ->route('seg.permisos.index')
            ->with('success', 'Permiso eliminado correctamente.');
    }
}