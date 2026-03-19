<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Modules\Tik\Models\TipoTicket;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'frmTicket_slcTipo' => [
                'required',
                Rule::exists('tik_tipos_ticket', 'id_tipo_ticket')
                    ->where(fn ($q) => $q->where('activo', true)->whereNull('deleted_at')),
            ],
            'frmTicket_slcTipoSolicitud' => [
                'nullable',
                Rule::exists('tik_tipos_ticket_rrhh', 'id_tipo_ticket_rrhh')
                    ->where(fn ($q) => $q->where('activo', true)->whereNull('deleted_at')),
            ],
            'frmTicket_slcFormato' => ['nullable'],
            'frmTicket_txaAsunto' => ['required', 'string', 'max:180'],
            'frmTicket_txaDescripcion' => ['required', 'string'],
            'frmTicket_FechaEntrega' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'frmTicket_slcTipo.required' => 'Debes seleccionar un tipo de ticket.',
            'frmTicket_txaAsunto.required' => 'Debes ingresar el asunto.',
            'frmTicket_txaDescripcion.required' => 'Debes ingresar la descripción.',
            'frmTicket_slcFormato.required' => 'Debes seleccionar el formato.',
            'frmTicket_FechaEntrega.required' => 'Debes ingresar la fecha requerida.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $idTipo = $this->input('frmTicket_slcTipo');

            if (!$idTipo) {
                return;
            }

            $tipo = TipoTicket::find($idTipo);

            if (!$tipo) {
                return;
            }

            if (
                $tipo->codigo === 'TALENTO_HUMANO' &&
                blank($this->input('frmTicket_slcTipoSolicitud'))
            ) {
                $validator->errors()->add(
                    'frmTicket_slcTipoSolicitud',
                    'Debes seleccionar el tipo de solicitud RRHH.'
                );
            }

            if ($tipo->codigo === 'COMUNICACIONES') {
                if (blank($this->input('frmTicket_slcFormato'))) {
                    $validator->errors()->add(
                        'frmTicket_slcFormato',
                        'Debes seleccionar el formato.'
                    );
                }

                if (blank($this->input('frmTicket_FechaEntrega'))) {
                    $validator->errors()->add(
                        'frmTicket_FechaEntrega',
                        'Debes ingresar la fecha requerida.'
                    );
                }
            }
        });
    }
}