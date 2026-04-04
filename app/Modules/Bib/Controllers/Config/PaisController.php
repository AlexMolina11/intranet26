<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\Pais;
use App\Modules\Bib\Requests\UpdatePaisRequest;

class PaisController extends BaseCodigoCatalogoController
{
    protected string $modelClass = Pais::class;
    protected string $viewPath = 'bib.config.codigo';
    protected string $routePrefix = 'bib.config.paises';
    protected string $pluralTitle = 'Países';
    protected string $singularTitle = 'País';

    public function edit(Pais $pais)
    {
        return view($this->viewPath . '.edit', [
            'item' => $pais,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdatePaisRequest $request, Pais $pais)
    {
        $pais->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}