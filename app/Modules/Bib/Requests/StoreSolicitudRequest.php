<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'motivo' => $this->motivo ? trim($this->motivo) : null,
            'observaciones' => $this->observaciones ? trim($this->observaciones) : null,
            'observaciones_internas' => $this->observaciones_internas ? trim($this->observaciones_internas) : null,
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
                'nullable',
                'integer',
                Rule::exists('bib_ejemplares', 'id_ejemplar')->whereNull('deleted_at'),
            ],
            'id_estado_solicitud' => [
                'required',
                'integer',
                Rule::exists('bib_estados_solicitud', 'id_estado_solicitud')->whereNull('deleted_at'),
            ],
            'fecha_solicitud' => ['required', 'date'],
            'fecha_requerida' => ['nullable', 'date', 'after_or_equal:fecha_solicitud'],
            'fecha_atencion' => ['nullable', 'date', 'after_or_equal:fecha_solicitud'],
            'motivo' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'observaciones_internas' => ['nullable', 'string'],
            'id_usuario_atiende' => [
                'nullable',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_requerida.after_or_equal' => 'La fecha requerida no puede ser menor que la fecha de solicitud.',
            'fecha_atencion.after_or_equal' => 'La fecha de atención no puede ser menor que la fecha de solicitud.',
        ];
    }
}