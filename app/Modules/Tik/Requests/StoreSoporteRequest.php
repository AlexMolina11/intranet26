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
            'id_seccion' => [
                'nullable',
                'integer',
                Rule::exists('tik_secciones', 'id_seccion')->whereNull('deleted_at'),
            ],
            'id_servicio' => [
                'nullable',
                'integer',
                Rule::exists('tik_servicios', 'id_servicio')->whereNull('deleted_at'),
            ],
            'id_incidencia' => [
                'nullable',
                'integer',
                Rule::exists('tik_incidencias', 'id_incidencia')->whereNull('deleted_at'),
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
                'string'
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
            'descripcion.required' => 'La descripción del soporte es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha fin no puede ser anterior a la fecha inicio.',
            'selecciones.required' => 'Debes seleccionar al menos un servicio con su incidencia.',
        ];
    }
}