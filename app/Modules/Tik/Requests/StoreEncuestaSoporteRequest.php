<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEncuestaSoporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'frmEncuestaTicket_numCalificacion' => ['required', 'integer', 'min:1', 'max:5'],
            'frmEncuestaTicket_txaComentario' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'frmEncuestaTicket_numCalificacion.required' => 'Debes seleccionar una calificación.',
            'frmEncuestaTicket_numCalificacion.integer' => 'La calificación no es válida.',
            'frmEncuestaTicket_numCalificacion.min' => 'La calificación mínima es 1.',
            'frmEncuestaTicket_numCalificacion.max' => 'La calificación máxima es 5.',
        ];
    }
}