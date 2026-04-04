<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDisponibilidadRequest extends FormRequest
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
            'permite_reserva' => $this->boolean('permite_reserva'),
            'permite_prestamo' => $this->boolean('permite_prestamo'),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('disponibilidad')?->id_disponibilidad;

        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('bib_disponibilidades', 'codigo')->ignore($id, 'id_disponibilidad')],
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'permite_reserva' => ['nullable', 'boolean'],
            'permite_prestamo' => ['nullable', 'boolean'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}