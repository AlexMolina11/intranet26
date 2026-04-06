<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEjemplarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo_inventario' => $this->codigo_inventario ? strtoupper(trim($this->codigo_inventario)) : null,
            'codigo_barras' => $this->codigo_barras ? trim($this->codigo_barras) : null,
            'ubicacion' => $this->ubicacion ? trim($this->ubicacion) : null,
            'condicion' => $this->condicion ? trim($this->condicion) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_recurso' => ['required', 'integer', 'exists:bib_recursos,id_recurso'],
            'codigo_inventario' => ['required', 'string', 'max:100', 'unique:bib_ejemplares,codigo_inventario'],
            'codigo_barras' => ['nullable', 'string', 'max:100'],
            'id_estado_ejemplar' => ['required', 'integer', 'exists:bib_estados_ejemplar,id_estado_ejemplar'],
            'id_disponibilidad' => ['required', 'integer', 'exists:bib_disponibilidades,id_disponibilidad'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'condicion' => ['nullable', 'string', 'max:255'],
            'fecha_adquisicion' => ['nullable', 'date'],
            'costo' => ['nullable', 'numeric', 'min:0'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}