<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTipoAccesoRequest extends FormRequest
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
            'permite_prestamo' => $this->boolean('permite_prestamo'),
            'requiere_autorizacion' => $this->boolean('requiere_autorizacion'),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('tipoAcceso')?->id_tipo_acceso;

        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('bib_tipos_acceso', 'codigo')->ignore($id, 'id_tipo_acceso')],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'permite_prestamo' => ['nullable', 'boolean'],
            'requiere_autorizacion' => ['nullable', 'boolean'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}