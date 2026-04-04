<?php

namespace App\Modules\Bib\Requests;

class StorePaisRequest extends BaseCodigoCatalogoRequest
{
    protected function table(): string { return 'bib_paises'; }
    protected function primaryKey(): string { return 'id_pais'; }
    protected function routeParam(): string { return 'pais'; }
}