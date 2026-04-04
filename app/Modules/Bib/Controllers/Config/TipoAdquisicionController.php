<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\TipoAdquisicion;
use App\Modules\Bib\Requests\UpdateTipoAdquisicionRequest;

class TipoAdquisicionController extends BaseCodigoCatalogoController
{
    protected string $modelClass = TipoAdquisicion::class;
    protected string $viewPath = 'bib.config.codigo';
    protected string $routePrefix = 'bib.config.tipos-adquisicion';
    protected string $pluralTitle = 'Tipos de adquisición';
    protected string $singularTitle = 'Tipo de adquisición';

    public function edit(TipoAdquisicion $tipoAdquisicion)
    {
        return view($this->viewPath . '.edit', [
            'item' => $tipoAdquisicion,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateTipoAdquisicionRequest $request, TipoAdquisicion $tipoAdquisicion)
    {
        $tipoAdquisicion->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}