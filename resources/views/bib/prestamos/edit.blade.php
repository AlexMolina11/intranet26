@extends('layouts.app')

@section('title', 'Gestionar préstamo')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.prestamos.update', $prestamo) }}">
            @csrf
            @method('PUT')
            @include('bib.prestamos._form', ['prestamo' => $prestamo, 'soloLecturaPolitica' => false])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.prestamos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
            @if(!$prestamo->fecha_devolucion)
                <button
                    type="submit"
                    formaction="{{ route('bib.prestamos.devolver', $prestamo) }}"
                    formmethod="POST"
                    class="btn btn-success"
                    onclick="return confirm('¿Registrar devolución?')"
                >
                    Devolver libro
                </button>
            @endif
        </form>
    </div>

    <div class="card" style="margin-top:16px;">
        <h2 style="margin-top:0;">Historial del préstamo</h2>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Movimiento</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                        <th>Vencimiento</th>
                        <th>Devolución</th>
                        <th>Multa acumulada</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamo->historial as $item)
                        <tr>
                            <td>{{ $item->tipo_movimiento }}</td>
                            <td>{{ optional($item->fecha_movimiento)->format('d/m/Y') }}</td>
                            <td>{{ $item->estadoPrestamo?->nombre ?? 'N/D' }}</td>
                            <td>{{ $item->usuarioAccion?->nombre_completo ?? 'N/D' }}</td>
                            <td>{{ optional($item->fecha_vencimiento)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ optional($item->fecha_devolucion)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ number_format((float) $item->multa_acumulada, 2) }}</td>
                            <td>{{ $item->observaciones ?? 'N/D' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection