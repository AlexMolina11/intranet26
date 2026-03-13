<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'icono' => $this->icono ? trim($this->icono) : null,
            'visible' => $this->boolean('visible'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_sistema' => ['required', 'exists:seg_sistemas,id_sistema'],
            'nombre' => ['required', 'string', 'max:120'],
            'icono' => ['nullable', 'string', 'max:100'],
            'orden' => ['required', 'integer', 'min:1'],
            'visible' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_sistema.required' => 'El sistema es obligatorio.',
            'id_sistema.exists' => 'El sistema seleccionado no es válido.',
            'nombre.required' => 'El nombre del menú es obligatorio.',
            'orden.required' => 'El orden es obligatorio.',
        ];
    }
}