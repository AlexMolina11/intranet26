<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstadoEjemplarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => $this->codigo ? strtoupper(trim($this->codigo)) : null,
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'es_prestable' => $this->boolean('es_prestable'),
            'afecta_inventario' => $this->boolean('afecta_inventario'),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('estadoEjemplar')?->id_estado_ejemplar;

        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('bib_estados_ejemplar', 'codigo')->ignore($id, 'id_estado_ejemplar')],
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'es_prestable' => ['nullable', 'boolean'],
            'afecta_inventario' => ['nullable', 'boolean'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}