<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Requests\StoreSistemaRequest;
use App\Modules\Seg\Requests\UpdateSistemaRequest;

class SistemaController extends Controller
{
    public function index()
    {
        $sistemas = Sistema::withCount('roles')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(10);

        return view('seg.sistemas.index', compact('sistemas'));
    }

    public function create()
    {
        return view('seg.sistemas.create');
    }

    public function store(StoreSistemaRequest $request)
    {
        Sistema::create($request->validated());

        return redirect()
            ->route('seg.sistemas.index')
            ->with('success', 'Sistema creado correctamente.');
    }

    public function edit(Sistema $sistema)
    {
        return view('seg.sistemas.edit', compact('sistema'));
    }

    public function update(UpdateSistemaRequest $request, Sistema $sistema)
    {
        $sistema->update($request->validated());

        return redirect()
            ->route('seg.sistemas.index')
            ->with('success', 'Sistema actualizado correctamente.');
    }

    public function toggle(Sistema $sistema)
    {
        $sistema->update([
            'activo' => !$sistema->activo,
        ]);

        return redirect()
            ->route('seg.sistemas.index')
            ->with('success', 'Estado del sistema actualizado correctamente.');
    }
}