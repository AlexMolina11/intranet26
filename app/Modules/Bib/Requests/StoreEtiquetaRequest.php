<?php

namespace App\Modules\Bib\Requests;

class StoreEtiquetaRequest extends BaseNombreCatalogoRequest
{
    protected function table(): string { return 'bib_etiquetas'; }
    protected function primaryKey(): string { return 'id_etiqueta'; }
    protected function routeParam(): string { return 'etiqueta'; }
}