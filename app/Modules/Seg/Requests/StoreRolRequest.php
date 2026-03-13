<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $sistema = $this->route('sistema');

        return [
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('seg_roles', 'nombre')
                    ->where(function ($query) use ($sistema) {
                        return $query->where('id_sistema', $sistema->id_sistema)
                            ->whereNull('deleted_at');
                    }),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe ese rol dentro del sistema seleccionado.',
        ];
    }
}