<?php

namespace App\Modules\Tik\Services;

use App\Mail\Tik\TicketFlowNotificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TicketFlowNotificationService
{
    public function enviarSegunEstado(object $ticket, string $destino = 'usuario'): void
    {
        $flujo = DB::table('tik_flujos_ticket')
            ->where('id_tipo_ticket', $ticket->id_tipo_ticket)
            ->where('id_estado_ticket', $ticket->id_estado_ticket)
            ->where('activo', 1)
            ->first();

        if (!$flujo) {
            return;
        }

        $mensaje = $destino === 'admin'
            ? ($flujo->mensaje_admin ?? '')
            : ($flujo->mensaje_usuario ?? '');

        if (blank($mensaje)) {
            return;
        }

        $mensaje = $this->reemplazarTokens($mensaje, $ticket);

        $correo = $destino === 'admin'
            ? ($ticket->responsable?->correo ?? null)
            : ($ticket->solicitante?->correo ?? null);

        if (blank($correo)) {
            return;
        }

        Mail::to($correo)->send(new TicketFlowNotificationMail($ticket, $mensaje, $destino));
    }

    private function reemplazarTokens(string $mensaje, object $ticket): string
    {
        $reemplazos = [
            '[[id]]' => $ticket->id_ticket ?? '',
            '[[titulo]]' => $ticket->titulo ?? '',
            '[[descripcion]]' => $ticket->descripcion ?? '',
        ];

        return str_replace(
            array_keys($reemplazos),
            array_values($reemplazos),
            $mensaje
        );
    }
}