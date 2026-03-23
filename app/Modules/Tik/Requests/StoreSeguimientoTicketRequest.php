<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSeguimientoTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'frmSeguimientoTicket_slcEstado' => [
                'required',
                Rule::exists('tik_estados_ticket', 'id_estado_ticket')
                    ->where(fn ($q) => $q->where('activo', true)->whereNull('deleted_at')),
            ],
            'frmSeguimientoTicket_txaComentario' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'frmSeguimientoTicket_slcEstado.required' => 'Debes seleccionar un estado.',
            'frmSeguimientoTicket_slcEstado.exists' => 'El estado seleccionado no es válido.',
        ];
    }
}