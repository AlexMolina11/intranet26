@extends('layouts.app')

@section('title', 'Mis tickets')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Mis tickets</h1>
                <p class="page-subtitle">Consulta y seguimiento de solicitudes</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('tik.tickets.create') }}" class="btn btn-primary">Nuevo ticket</a>
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