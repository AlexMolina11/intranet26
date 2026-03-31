<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSoporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $selecciones = $this->input('selecciones');

        $this->merge([
            'selecciones_array' => is_string($selecciones)
                ? json_decode($selecciones, true)
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id_ticket' => [
                'nullable',
                'integer',
                Rule::exists('tik_tickets', 'id_ticket')->whereNull('deleted_at'),
            ],
            'id_usuario_solicitante' => [
                'required',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->whereNull('deleted_at'),
            ],
            'id_departamento' => [
                'required',
                'integer',
                Rule::exists('org_departamentos', 'id_departamento')->whereNull('deleted_at'),
            ],
            'id_proyecto' => [
                'nullable',
                'integer',
                Rule::exists('org_proyectos', 'id_proyecto')->whereNull('deleted_at'),
            ],
            'tipo_registro' => [
                'required',
                Rule::in(['TICKET', 'AVANCE', 'EXTERNO']),
            ],
            'asunto' => [
                'required',
                'string',
                'max:255',
            ],
            'descripcion' => [
                'required',
                'string',
            ],
            'fecha_inicio' => [
                'nullable',
                'date',
            ],
            'fecha_fin' => [
                'nullable',
                'date',
                'after_or_equal:fecha_inicio',
            ],
            'selecciones' => [
                'required',
                'string',
            ],
            'selecciones_array' => [
                'required',
                'array',
                'min:1',
            ],
            'selecciones_array.*.servicio_id' => [
                'required',
                'integer',
                Rule::exists('tik_servicios', 'id_servicio')->whereNull('deleted_at'),
            ],
            'selecciones_array.*.incidencia_id' => [
                'required',
                'integer',
                Rule::exists('tik_incidencias', 'id_incidencia')->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario_solicitante.required' => 'Debes seleccionar un solicitante.',
            'id_departamento.required' => 'Debes seleccionar un departamento.',
            'tipo_registro.required' => 'Debes seleccionar el tipo de registro.',
            'tipo_registro.in' => 'El tipo de registro enviado no es válido.',
            'asunto.required' => 'El asunto del soporte es obligatorio.',
            'asunto.max' => 'El asunto del soporte no puede exceder 255 caracteres.',
            'descripcion.required' => 'La descripción del soporte es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio no es válida.',
            'fecha_fin.date' => 'La fecha fin no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha fin no puede ser anterior a la fecha inicio.',
            'selecciones.required' => 'Debes seleccionar al menos un servicio con su incidencia.',
            'selecciones.string' => 'Las selecciones enviadas no son válidas.',
            'selecciones_array.required' => 'Debes seleccionar al menos un servicio con su incidencia.',
            'selecciones_array.array' => 'Las selecciones enviadas no tienen un formato válido.',
            'selecciones_array.min' => 'Debes seleccionar al menos un servicio con su incidencia.',
            'selecciones_array.*.servicio_id.required' => 'Cada selección debe incluir un servicio.',
            'selecciones_array.*.servicio_id.integer' => 'Uno de los servicios seleccionados no es válido.',
            'selecciones_array.*.servicio_id.exists' => 'Uno de los servicios seleccionados no existe o no está disponible.',
            'selecciones_array.*.incidencia_id.required' => 'Cada selección debe incluir una incidencia.',
            'selecciones_array.*.incidencia_id.integer' => 'Una de las incidencias seleccionadas no es válida.',
            'selecciones_array.*.incidencia_id.exists' => 'Una de las incidencias seleccionadas no existe o no está disponible.',
        ];
    }
}