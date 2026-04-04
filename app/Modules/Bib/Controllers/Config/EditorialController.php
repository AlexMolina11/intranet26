<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Modules\Bib\Models\Editorial;
use App\Modules\Bib\Requests\UpdateEditorialRequest;

class EditorialController extends BaseNombreCatalogoController
{
    protected string $modelClass = Editorial::class;
    protected string $viewPath = 'bib.config.editoriales';
    protected string $routePrefix = 'bib.config.editoriales';
    protected string $pluralTitle = 'Editoriales';
    protected string $singularTitle = 'Editorial';

    public function edit(Editorial $editorial)
    {
        return view($this->viewPath . '.edit', [
            'item' => $editorial,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function update(UpdateEditorialRequest $request, Editorial $editorial)
    {
        $editorial->update($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' actualizado correctamente.');
    }
}