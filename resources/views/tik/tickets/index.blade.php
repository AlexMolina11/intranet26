@extends('layouts.app')

@section('title', 'Mis tickets')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Mis tickets</h1>
                <p class="page-subtitle">Consulta de solicitudes realizadas por el usuario</p>
            </div>

            <div class="page-header-actions" style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('tik.tickets.create') }}" class="btn btn-primary">Nuevo ticket</a>

                @if (auth()->user()->tienePermiso(['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER']))
                    <a href="{{ route('tik.admin.tickets.index') }}" class="btn btn-secondary">Panel administrador</a>
                @endif

                @if (auth()->user()->tienePermiso(['TIK_PANEL_GESTOR_VER', 'TIK_TICKETS_GESTOR_VER']))
                    <a href="{{ route('tik.gestor.tickets.index') }}" class="btn btn-secondary">Panel gestor</a>
                @endif
            </div>
        </div>

        <form id="frmBuscarTicket" style="margin-top:20px;">
            @csrf

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                <div class="form-group">
                    <label class="form-label">Desde</label>
                    <input type="date" name="frmBuscarTicket_dateDesde" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="frmBuscarTicket_dateHasta" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="frmBuscarTicket_slcEstado" class="form-control">
                        <option value="0">Todos</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id_estado_ticket }}">{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo</label>
                    <select name="frmBuscarTicket_slcTipo" class="form-control">
                        <option value="0">Todos</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_tipo_ticket }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Registros</label>
                    <select name="frmBuscarTicket_slcRegistros" class="form-control">
                        <option value="0">Todos</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:16px;">
                <button type="button" class="btn btn-primary" onclick="buscarTickets()">Buscar</button>
            </div>
        </form>

        <div id="resultadoTickets" style="margin-top:24px;"></div>

        <div style="margin-top:24px;">
            <h2 style="margin:0 0 12px 0;">Últimos tickets</h2>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Asunto</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Responsable</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ticketsRecientes as $ticket)
                            <tr>
                                <td>{{ $ticket->codigo }}</td>
                                <td>{{ $ticket->asunto }}</td>
                                <td>{{ $ticket->tipoTicket?->nombre }}</td>
                                <td>{{ $ticket->estadoTicket?->nombre }}</td>
                                <td>
                                    @if ($ticket->responsable)
                                        {{ trim(($ticket->responsable->nombres ?? '') . ' ' . ($ticket->responsable->apellidos ?? '')) }}
                                    @else
                                        Sin asignar
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tik.tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-secondary">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No hay tickets registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function buscarTickets() {
            const form = document.getElementById('frmBuscarTicket');
            const formData = new FormData(form);

            const response = await fetch('{{ route('tik.tickets.search') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            const data = await response.json();
            const contenedor = document.getElementById('resultadoTickets');

            if (!data.success) {
                contenedor.innerHTML = `<div class="alert alert-warning">${data.message}</div>`;
                return;
            }

            let html = `
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Asunto</th>
                                <th>Registro</th>
                                <th>Estado</th>
                                <th>Asignado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            data.tickets.forEach(ticket => {
                html += `
                    <tr>
                        <td>${ticket.codigo ?? ''}</td>
                        <td>${ticket.asunto ?? ''}</td>
                        <td>${ticket.registro ?? ''}</td>
                        <td>${ticket.nom_estado ?? ''}</td>
                        <td>${ticket.asignado_nom ?? ''}</td>
                        <td>
                            <a href="/tik/tickets/${ticket.id_ticket}" class="btn btn-sm btn-secondary">Ver</a>
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table></div>`;
            contenedor.innerHTML = html;
        }
    </script>
@endsection