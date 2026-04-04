<?php

namespace App\Modules\Bib\Requests;

class StoreTipoAdquisicionRequest extends BaseCodigoCatalogoRequest
{
    protected function table(): string { return 'bib_tipos_adquisicion'; }
    protected function primaryKey(): string { return 'id_tipo_adquisicion'; }
    protected function routeParam(): string { return 'tipoAdquisicion'; }
}