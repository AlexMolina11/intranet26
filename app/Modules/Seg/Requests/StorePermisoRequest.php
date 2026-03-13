<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => $this->codigo ? trim(strtolower($this->codigo)) : null,
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id_sistema' => ['required', 'exists:seg_sistemas,id_sistema'],
            'codigo' => [
                'required',
                'string',
                'max:150',
                Rule::unique('seg_permisos', 'codigo')->whereNull('deleted_at'),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_sistema.required' => 'El sistema es obligatorio.',
            'id_sistema.exists' => 'El sistema seleccionado no es válido.',
            'codigo.required' => 'El código del permiso es obligatorio.',
            'codigo.unique' => 'Ya existe un permiso con ese código.',
            'nombre.required' => 'El nombre del permiso es obligatorio.',
        ];
    }
}