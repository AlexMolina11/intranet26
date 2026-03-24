<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanificarTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_planificada' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_planificada.required' => 'Debes indicar una fecha planificada.',
            'fecha_planificada.date' => 'La fecha planificada no es válida.',
            'fecha_planificada.after_or_equal' => 'La fecha planificada no puede ser anterior a hoy.',
        ];
    }
}