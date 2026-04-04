<?php

namespace App\Modules\Bib\Requests;

class StoreNivelBibliograficoRequest extends BaseCodigoCatalogoRequest
{
    protected function table(): string { return 'bib_niveles_bibliograficos'; }
    protected function primaryKey(): string { return 'id_nivel_bibliografico'; }
    protected function routeParam(): string { return 'nivelBibliografico'; }
}