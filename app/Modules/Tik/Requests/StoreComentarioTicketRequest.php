<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'frmComentarioTicket_txaComentario' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'frmComentarioTicket_txaComentario.required' => 'Debes ingresar un comentario.',
        ];
    }
}