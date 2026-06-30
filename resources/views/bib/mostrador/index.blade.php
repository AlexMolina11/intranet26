@extends('layouts.app')

@section('title', 'Mostrador Biblioteca')

@section('content')
@include('bib.partials._operation_styles')

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header">
            <a href="{{ route('bib.operacion.index') }}" class="bib-mode-back">← Volver a Operación Biblioteca</a>
            <h1 class="bib-mode-title">Mostrador</h1>
            <div class="bib-mode-subtitle">Atención directa de usuarios: préstamos, entregas, devoluciones y renovaciones.</div>
        </div>

        <div class="bib-action-grid">
            <a href="{{ route('bib.prestamos.create') }}" class="bib-action-card">
                <div class="bib-action-icon">📗</div>
                <h2>Nuevo préstamo</h2>
                <p>Registrar préstamo directo para un usuario presente.</p>
                <div class="bib-action-footer">Registrar préstamo</div>
            </a>

            <a href="{{ route('bib.prestamos.index', ['estado' => 'PENDIENTE_ENTREGA']) }}" class="bib-action-card">
                <div class="bib-action-icon">📦</div>
                <h2>Entregas</h2>
                <p>Gestionar préstamos aprobados que están pendientes de entrega.</p>
                <div class="bib-action-footer">
                    Ver entregas
                    @if($pendientesEntrega > 0)
                        <span class="bib-alert-count">{{ $pendientesEntrega }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.prestamos.index', ['estado' => 'ENTREGADO']) }}" class="bib-action-card">
                <div class="bib-action-icon">↩️</div>
                <h2>Devoluciones</h2>
                <p>Buscar préstamos activos y registrar la devolución del ejemplar.</p>
                <div class="bib-action-footer">Registrar devolución</div>
            </a>

            <a href="{{ route('bib.prestamos.index', ['estado' => 'ENTREGADO']) }}" class="bib-action-card">
                <div class="bib-action-icon">🔄</div>
                <h2>Renovaciones</h2>
                <p>Revisar préstamos activos y renovar si la política lo permite.</p>
                <div class="bib-action-footer">Gestionar renovaciones</div>
            </a>

            <a href="{{ route('bib.prestamos.index') }}" class="bib-action-card">
                <div class="bib-action-icon">📚</div>
                <h2>Préstamos activos</h2>
                <p>Consultar préstamos entregados, vencidos o pendientes de devolución.</p>
                <div class="bib-action-footer">
                    Ver préstamos
                    @if($prestamosActivos > 0)
                        <span class="bib-alert-count">{{ $prestamosActivos }}</span>
                    @endif
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
