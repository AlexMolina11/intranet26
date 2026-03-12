<?php

namespace App\Modules\Org\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Requests\StoreDepartamentoRequest;
use App\Modules\Org\Requests\UpdateDepartamentoRequest;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::orderBy('id_departamento', 'desc')->paginate(10);

        return view('org.departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('org.departamentos.create');
    }

    public function store(StoreDepartamentoRequest $request)
    {
        Departamento::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? true,
        ]);

        return redirect()
            ->route('org.departamentos.index')
            ->with('success', 'Departamento creado correctamente.');
    }

    public function edit(Departamento $departamento)
    {
        return view('org.departamentos.edit', compact('departamento'));
    }

    public function update(UpdateDepartamentoRequest $request, Departamento $departamento)
    {
        $departamento->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? false,
        ]);

        return redirect()
            ->route('org.departamentos.index')
            ->with('success', 'Departamento actualizado correctamente.');
    }
}