<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\NivelBibliografico;
use App\Modules\Bib\Requests\UpdateNivelBibliograficoRequest;

class NivelBibliograficoController extends BaseCodigoCatalogoController
{
    protected string $modelClass = NivelBibliografico::class;
    protected string $viewPath = 'bib.config.codigo';
    protected string $routePrefix = 'bib.config.niveles-bibliograficos';
    protected string $pluralTitle = 'Niveles bibliográficos';
    protected string $singularTitle = 'Nivel bibliográfico';

    public function edit(NivelBibliografico $nivelBibliografico)
    {
        return view($this->viewPath . '.edit', [
            'item' => $nivelBibliografico,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateNivelBibliograficoRequest $request, NivelBibliografico $nivelBibliografico)
    {
        $nivelBibliografico->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}