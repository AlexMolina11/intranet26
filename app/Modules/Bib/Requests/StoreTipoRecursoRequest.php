<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTipoRecursoRequest extends FormRequest
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
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('tipoRecurso')?->id_tipo_recurso;

        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('bib_tipos_recurso', 'codigo')->ignore($id, 'id_tipo_recurso')],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'dias_prestamo_default' => ['required', 'integer', 'min:0'],
            'renovaciones_default' => ['required', 'integer', 'min:0'],
            'multa_diaria_default' => ['required', 'numeric', 'min:0'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}