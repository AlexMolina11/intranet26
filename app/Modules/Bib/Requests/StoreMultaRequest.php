<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $pagada = $this->boolean('pagada');

        $this->merge([
            'motivo' => $this->motivo ? trim($this->motivo) : null,
            'observaciones' => $this->observaciones ? trim($this->observaciones) : null,
            'pagada' => $pagada,
            'activo' => $this->boolean('activo'),
            'fecha_pago' => $pagada ? $this->fecha_pago : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id_prestamo' => [
                'required',
                'integer',
                Rule::exists('bib_prestamos', 'id_prestamo')->whereNull('deleted_at'),
            ],
            'id_usuario' => [
                'required',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'id_usuario_registra' => [
                'nullable',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'fecha_multa' => ['required', 'date'],
            'dias_atraso' => ['required', 'integer', 'min:0'],
            'monto' => ['required', 'numeric', 'min:0'],
            'monto_pagado' => ['required', 'numeric', 'min:0'],
            'pagada' => ['nullable', 'boolean'],
            'fecha_pago' => ['nullable', 'date', 'after_or_equal:fecha_multa'],
            'motivo' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_pago.after_or_equal' => 'La fecha de pago no puede ser menor que la fecha de multa.',
        ];
    }
}