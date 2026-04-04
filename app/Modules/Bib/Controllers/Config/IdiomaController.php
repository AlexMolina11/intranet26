<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\Idioma;
use App\Modules\Bib\Requests\UpdateIdiomaRequest;

class IdiomaController extends BaseCodigoCatalogoController
{
    protected string $modelClass = Idioma::class;
    protected string $viewPath = 'bib.config.codigo';
    protected string $routePrefix = 'bib.config.idiomas';
    protected string $pluralTitle = 'Idiomas';
    protected string $singularTitle = 'Idioma';

    public function edit(Idioma $idioma)
    {
        return view($this->viewPath . '.edit', [
            'item' => $idioma,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateIdiomaRequest $request, Idioma $idioma)
    {
        $idioma->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}