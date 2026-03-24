<?php

namespace App\Modules\Org\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartamentoRequest extends FormRequest
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
        return [
            'codigo' => ['nullable', 'string', 'max:30', 'unique:org_departamentos,codigo'],
            'nombre' => ['required', 'string', 'max:150', 'unique:org_departamentos,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'Ya existe un departamento con ese código.',
            'nombre.required' => 'El nombre del departamento es obligatorio.',
            'nombre.unique' => 'Ya existe un departamento con ese nombre.',
        ];
    }
}
