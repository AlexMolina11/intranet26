<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Rol;
use App\Modules\Seg\Requests\StoreRolRequest;
use App\Modules\Seg\Requests\UpdateRolRequest;

class RolController extends Controller
{
    public function index(Sistema $sistema)
    {
        $roles = Rol::where('id_sistema', $sistema->id_sistema)
            ->orderBy('nombre')
            ->paginate(10);

        return view('seg.roles.index', compact('sistema', 'roles'));
    }

    public function create(Sistema $sistema)
    {
        return view('seg.roles.create', compact('sistema'));
    }

    public function store(StoreRolRequest $request, Sistema $sistema)
    {
        $datos = $request->validated();
        $datos['id_sistema'] = $sistema->id_sistema;

        Rol::create($datos);

        return redirect()
            ->route('seg.sistemas.roles.index', $sistema)
            ->with('success', 'Rol creado correctamente.');
    }

    public function edit(Sistema $sistema, Rol $rol)
    {
        abort_if($rol->id_sistema !== $sistema->id_sistema, 404);

        return view('seg.roles.edit', compact('sistema', 'rol'));
    }

    public function update(UpdateRolRequest $request, Sistema $sistema, Rol $rol)
    {
        abort_if($rol->id_sistema !== $sistema->id_sistema, 404);

        $rol->update($request->validated());

        return redirect()
            ->route('seg.sistemas.roles.index', $sistema)
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function toggle(Sistema $sistema, Rol $rol)
    {
        abort_if($rol->id_sistema !== $sistema->id_sistema, 404);

        $rol->update([
            'activo' => !$rol->activo,
        ]);

        return redirect()
            ->route('seg.sistemas.roles.index', $sistema)
            ->with('success', 'Estado del rol actualizado correctamente.');
    }
}