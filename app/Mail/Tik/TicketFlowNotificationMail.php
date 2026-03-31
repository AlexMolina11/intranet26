<?php

namespace App\Mail\Tik;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketFlowNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public object $ticket,
        public string $mensajeHtml,
        public string $destino = 'usuario'
    ) {
    }

    public function build(): self
    {
        $asunto = 'Actualización de ticket #' . ($this->ticket->id_ticket ?? '');

        return $this->subject($asunto)
            ->view('emails.tik.flujo-ticket');
    }
}