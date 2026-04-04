<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Autor;
use App\Modules\Bib\Requests\StoreAutorRequest;
use App\Modules\Bib\Requests\UpdateAutorRequest;

class AutorController extends Controller
{
    public function index()
    {
        $items = Autor::query()
            ->orderBy('nombre_completo')
            ->paginate(15)
            ->withQueryString();

        return view('bib.config.autores.index', compact('items'));
    }

    public function create()
    {
        return view('bib.config.autores.create');
    }

    public function store(StoreAutorRequest $request)
    {
        Autor::create($request->validated());

        return redirect()
            ->route('bib.config.autores.index')
            ->with('success', 'Autor creado correctamente.');
    }

    public function edit(Autor $autor)
    {
        return view('bib.config.autores.edit', compact('autor'));
    }

    public function update(UpdateAutorRequest $request, Autor $autor)
    {
        $autor->update($request->validated());

        return redirect()
            ->route('bib.config.autores.index')
            ->with('success', 'Autor actualizado correctamente.');
    }
}