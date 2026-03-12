<?php

namespace App\Modules\Org\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProyectoRequest extends FormRequest
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
        $id = $this->route('proyecto')->id_proyecto ?? null;

        return [
            'codigo' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('org_proyectos', 'codigo')->ignore($id, 'id_proyecto'),
            ],
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('org_proyectos', 'nombre')->ignore($id, 'id_proyecto'),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'Ya existe un proyecto con ese código.',
            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'nombre.unique' => 'Ya existe un proyecto con ese nombre.',
        ];
    }
}