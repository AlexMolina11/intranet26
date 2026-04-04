<?php

namespace App\Modules\Bib\Requests;

class StoreEditorialRequest extends BaseNombreCatalogoRequest
{
    protected function table(): string { return 'bib_editoriales'; }
    protected function primaryKey(): string { return 'id_editorial'; }
    protected function routeParam(): string { return 'editorial'; }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'sigla' => ['nullable', 'string', 'max:50'],
            'sitio_web' => ['nullable', 'string', 'max:255'],
        ]);
    }
}