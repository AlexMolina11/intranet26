<?php

namespace App\Modules\Bib\Requests;

class StoreGeneroRequest extends BaseCodigoCatalogoRequest
{
    protected function table(): string { return 'bib_generos'; }
    protected function primaryKey(): string { return 'id_genero'; }
    protected function routeParam(): string { return 'genero'; }
}