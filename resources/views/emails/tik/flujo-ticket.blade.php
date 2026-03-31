<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización de ticket</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #222;">
    <div style="max-width: 700px; margin: 0 auto; padding: 24px;">
        <h2 style="margin-top: 0;">Actualización de ticket #{{ $ticket->id_ticket ?? '' }}</h2>

        <div style="margin-bottom: 20px;">
            {!! $mensajeHtml !!}
        </div>

        <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%;">
            <tr>
                <th align="left">Ticket</th>
                <td>#{{ $ticket->id_ticket ?? '' }}</td>
            </tr>
            <tr>
                <th align="left">Título</th>
                <td>{{ $ticket->titulo ?? 'Sin título' }}</td>
            </tr>
            <tr>
                <th align="left">Descripción</th>
                <td>{{ $ticket->descripcion ?? 'Sin descripción' }}</td>
            </tr>
        </table>

        <p style="margin-top: 24px;">
            Este correo fue generado automáticamente por Intranet 2026.
        </p>
    </div>
</body>
</html>