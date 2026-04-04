<?php

namespace App\Modules\Bib\Requests;

class StoreIdiomaRequest extends BaseCodigoCatalogoRequest
{
    protected function table(): string { return 'bib_idiomas'; }
    protected function primaryKey(): string { return 'id_idioma'; }
    protected function routeParam(): string { return 'idioma'; }
}