<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\Clasificacion;
use App\Modules\Bib\Requests\StoreClasificacionRequest;
use App\Modules\Bib\Requests\UpdateClasificacionRequest;

class ClasificacionController extends BaseCodigoCatalogoController
{
    protected string $modelClass = Clasificacion::class;
    protected string $viewPath = 'bib.config.codigo';
    protected string $routePrefix = 'bib.config.clasificaciones';
    protected string $pluralTitle = 'Clasificaciones';
    protected string $singularTitle = 'Clasificación';

    public function edit(Clasificacion $clasificacion)
    {
        return view($this->viewPath . '.edit', [
            'item' => $clasificacion,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateClasificacionRequest $request, Clasificacion $clasificacion)
    {
        $clasificacion->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}