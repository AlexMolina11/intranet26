<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePoliticaPrestamoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'observaciones' => $this->observaciones ? trim($this->observaciones) : null,
            'permite_reserva' => $this->boolean('permite_reserva'),
            'requiere_aprobacion' => $this->boolean('requiere_aprobacion'),
            'permite_prestamo_externo' => $this->boolean('permite_prestamo_externo'),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('politica')?->id_politica_prestamo;

        return [
            'id_tipo_recurso' => [
                'required',
                'integer',
                Rule::exists('bib_tipos_recurso', 'id_tipo_recurso')->whereNull('deleted_at'),
                Rule::unique('bib_politicas_prestamo', 'id_tipo_recurso')
                    ->ignore($id, 'id_politica_prestamo')
                    ->whereNull('deleted_at'),
            ],
            'dias_prestamo' => ['required', 'integer', 'min:0'],
            'max_renovaciones' => ['required', 'integer', 'min:0'],
            'max_prestamos_usuario' => ['required', 'integer', 'min:1'],
            'multa_diaria' => ['required', 'numeric', 'min:0'],
            'permite_reserva' => ['nullable', 'boolean'],
            'requiere_aprobacion' => ['nullable', 'boolean'],
            'permite_prestamo_externo' => ['nullable', 'boolean'],
            'observaciones' => ['nullable', 'string'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}