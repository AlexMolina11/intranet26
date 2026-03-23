<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassifyTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'clasificacion' => [
                'required',
                Rule::in(['NORMAL', 'PROYECTO', 'NO_APLICA']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'clasificacion.required' => 'Debes seleccionar una clasificación.',
            'clasificacion.in' => 'La clasificación seleccionada no es válida.',
        ];
    }
}