<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\Genero;
use App\Modules\Bib\Requests\UpdateGeneroRequest;

class GeneroController extends BaseCodigoCatalogoController
{
    protected string $modelClass = Genero::class;
    protected string $viewPath = 'bib.config.codigo';
    protected string $routePrefix = 'bib.config.generos';
    protected string $pluralTitle = 'Géneros';
    protected string $singularTitle = 'Género';

    public function edit(Genero $genero)
    {
        return view($this->viewPath . '.edit', [
            'item' => $genero,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateGeneroRequest $request, Genero $genero)
    {
        $genero->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}