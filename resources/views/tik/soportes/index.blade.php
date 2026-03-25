@extends('layouts.app')

@section('title', 'Soportes')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin: 0;">Soportes y avances</h1>
                <p class="page-subtitle">Registro de avances, cierres y soportes externos</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('tik.soportes.create') }}" class="btn btn-primary">Nuevo soporte</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('tik.soportes.index') }}" style="margin-bottom: 20px;">
            <div style="display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="id_departamento">Departamento</label>
                    <select name="id_departamento" id="id_departamento" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}" {{ request('id_departamento') == $departamento->id_departamento ? 'selected' : '' }}>
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_proyecto">Proyecto</label>
                    <select name="id_proyecto" id="id_proyecto" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($proyectos as $proyecto)
                            <option value="{{ $proyecto->id_proyecto }}" {{ request('id_proyecto') == $proyecto->id_proyecto ? 'selected' : '' }}>
                                {{ $proyecto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tipo_registro">Tipo</label>
                    <select name="tipo_registro" id="tipo_registro" class="form-control">
                        <option value="">Todos</option>
                        <option value="TICKET" {{ request('tipo_registro') === 'TICKET' ? 'selected' : '' }}>TICKET</option>
                        <option value="AVANCE" {{ request('tipo_registro') === 'AVANCE' ? 'selected' : '' }}>AVANCE</option>
                        <option value="EXTERNO" {{ request('tipo_registro') === 'EXTERNO' ? 'selected' : '' }}>EXTERNO</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('tik.soportes.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        @if ($soportes->count())
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Asunto</th>
                            <th>Solicitante</th>
                            <th>Departamento</th>
                            <th>Proyecto</th>
                            <th>Ticket</th>
                            <th>Notificado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soportes as $soporte)
                            <tr>
                                <td>#{{ $soporte->id_soporte }}</td>
                                <td>{{ $soporte->tipo_registro }}</td>
                                <td>{{ $soporte->asunto }}</td>
                                <td>
                                    {{ trim(($soporte->solicitante?->nombres ?? '') . ' ' . ($soporte->solicitante?->apellidos ?? '')) ?: 'N/D' }}
                                </td>
                                <td>{{ $soporte->departamento?->nombre ?? 'N/D' }}</td>
                                <td>{{ $soporte->proyecto?->nombre ?? 'N/D' }}</td>
                                <td>{{ $soporte->ticket?->codigo ?? 'Sin ticket' }}</td>
                                <td>{{ $soporte->fue_notificado ? 'Sí' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $soportes->links() }}
            </div>
        @else
            <div class="empty-state">
                <p style="margin: 0;">No hay soportes registrados con los filtros actuales.</p>
            </div>
        @endif
    </div>
@endsection