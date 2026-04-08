<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePrestamoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'observaciones' => $this->observaciones ? trim($this->observaciones) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_usuario' => [
                'required',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'id_recurso' => [
                'required',
                'integer',
                Rule::exists('bib_recursos', 'id_recurso')->whereNull('deleted_at'),
            ],
            'id_ejemplar' => [
                'required',
                'integer',
                Rule::exists('bib_ejemplares', 'id_ejemplar')->whereNull('deleted_at'),
            ],
            'id_estado_prestamo' => [
                'required',
                'integer',
                Rule::exists('bib_estados_prestamo', 'id_estado_prestamo')->whereNull('deleted_at'),
            ],
            'id_solicitud' => [
                'nullable',
                'integer',
                Rule::exists('bib_solicitudes', 'id_solicitud')->whereNull('deleted_at'),
            ],
            'id_usuario_entrega' => [
                'nullable',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'id_usuario_recibe' => [
                'nullable',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'fecha_prestamo' => ['required', 'date'],
            'fecha_vencimiento' => ['required', 'date', 'after_or_equal:fecha_prestamo'],
            'fecha_devolucion' => ['nullable', 'date', 'after_or_equal:fecha_prestamo'],
            'dias_autorizados' => ['required', 'integer', 'min:0'],
            'renovaciones_usadas' => ['required', 'integer', 'min:0'],
            'renovaciones_maximas' => ['required', 'integer', 'min:0'],
            'multa_diaria' => ['required', 'numeric', 'min:0'],
            'multa_acumulada' => ['required', 'numeric', 'min:0'],
            'observaciones' => ['nullable', 'string'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_vencimiento.after_or_equal' => 'La fecha de vencimiento no puede ser menor que la fecha de préstamo.',
            'fecha_devolucion.after_or_equal' => 'La fecha de devolución no puede ser menor que la fecha de préstamo.',
        ];
    }
}