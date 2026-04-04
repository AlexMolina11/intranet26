<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstadoPrestamoRequest extends FormRequest
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
            'es_inicial' => $this->boolean('es_inicial'),
            'es_final' => $this->boolean('es_final'),
            'genera_multa' => $this->boolean('genera_multa'),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('estadoPrestamo')?->id_estado_prestamo;

        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('bib_estados_prestamo', 'codigo')->ignore($id, 'id_estado_prestamo')],
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'es_inicial' => ['nullable', 'boolean'],
            'es_final' => ['nullable', 'boolean'],
            'genera_multa' => ['nullable', 'boolean'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}