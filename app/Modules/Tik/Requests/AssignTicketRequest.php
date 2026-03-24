<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Modules\Tik\Models\Ticket;

class AssignTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario_responsable' => [
                'required',
                'integer',
                Rule::exists('seg_usuarios', 'id_usuario')->where(function ($query) {
                    $query->where('activo', 1)
                        ->whereNull('deleted_at');
                }),
                function ($attribute, $value, $fail) {
                    $idTicket = (int) $this->route('ticket');

                    $ticket = Ticket::select('id_ticket', 'id_area_responsable')
                        ->find($idTicket);

                    if (!$ticket) {
                        $fail('El ticket indicado no existe.');
                        return;
                    }

                    if (!$ticket->id_area_responsable) {
                        $fail('El ticket no tiene un área responsable definida.');
                        return;
                    }

                    $perteneceArea = DB::table('org_usuario_area')
                        ->where('id_usuario', (int) $value)
                        ->where('id_area', (int) $ticket->id_area_responsable)
                        ->exists();

                    if (!$perteneceArea) {
                        $fail('El usuario seleccionado no pertenece al área responsable del ticket.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario_responsable.required' => 'Debes seleccionar un responsable.',
            'id_usuario_responsable.integer' => 'El responsable enviado no es válido.',
            'id_usuario_responsable.exists' => 'El responsable seleccionado no existe o no está activo.',
        ];
    }
}