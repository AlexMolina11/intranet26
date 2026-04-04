<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\Etiqueta;
use App\Modules\Bib\Requests\UpdateEtiquetaRequest;

class EtiquetaController extends BaseNombreCatalogoController
{
    protected string $modelClass = Etiqueta::class;
    protected string $viewPath = 'bib.config.etiquetas';
    protected string $routePrefix = 'bib.config.etiquetas';
    protected string $pluralTitle = 'Etiquetas';
    protected string $singularTitle = 'Etiqueta';

    public function edit(Etiqueta $etiqueta)
    {
        return view($this->viewPath . '.edit', [
            'item' => $etiqueta,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateEtiquetaRequest $request, Etiqueta $etiqueta)
    {
        $etiqueta->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}