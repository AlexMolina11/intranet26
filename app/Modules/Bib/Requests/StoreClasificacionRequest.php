<?php

namespace App\Modules\Bib\Requests;

class StoreClasificacionRequest extends BaseCodigoCatalogoRequest
{
    protected function table(): string { return 'bib_clasificaciones'; }
    protected function primaryKey(): string { return 'id_clasificacion'; }
    protected function routeParam(): string { return 'clasificacion'; }
}