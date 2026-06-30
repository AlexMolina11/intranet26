@extends('layouts.app')

@section('title', 'Panel Consultas')

@section('content')
@include('bib.partials._operation_styles')

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header">
            <a href="{{ route('bib.operacion.index') }}" class="bib-mode-back">← Volver a Operación Biblioteca</a>
            <h1 class="bib-mode-title">Consultas</h1>
            <div class="bib-mode-subtitle">Consulta bibliográfica, reportes básicos y seguimiento operativo.</div>
        </div>

        <div class="bib-action-grid">
            <a href="{{ route('bib.consulta.index') }}" class="bib-action-card">
                <div class="bib-action-icon">🔎</div>
                <h2>Consulta bibliográfica</h2>
                <p>Buscar recursos disponibles en el catálogo de biblioteca.</p>
                <div class="bib-action-footer">Buscar recursos</div>
            </a>

            <a href="{{ route('bib.prestamos.index') }}" class="bib-action-card">
                <div class="bib-action-icon">📚</div>
                <h2>Préstamos</h2>
                <p>Consultar préstamos registrados, activos, vencidos o devueltos.</p>
                <div class="bib-action-footer">
                    Ver préstamos
                    @if($recursosPrestados > 0)
                        <span class="bib-alert-count is-neutral">{{ $recursosPrestados }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.multas.index', ['estado' => 'pendientes']) }}" class="bib-action-card">
                <div class="bib-action-icon">👤</div>
                <h2>Usuarios con multas</h2>
                <p>Consultar usuarios que mantienen multas pendientes de pago.</p>
                <div class="bib-action-footer">
                    Ver usuarios
                    @if($usuariosConMultas > 0)
                        <span class="bib-alert-count">{{ $usuariosConMultas }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.ejemplares.index') }}" class="bib-action-card">
                <div class="bib-action-icon">⚠️</div>
                <h2>Recursos dañados</h2>
                <p>Consultar ejemplares marcados como dañados o fuera de servicio.</p>
                <div class="bib-action-footer">
                    Ver dañados
                    @if($recursosDanados > 0)
                        <span class="bib-alert-count">{{ $recursosDanados }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.reportes.index') }}" class="bib-action-card">
                <div class="bib-action-icon">📊</div>
                <h2>Reportes</h2>
                <p>Acceder a reportes básicos de operación de biblioteca.</p>
                <div class="bib-action-footer">Ver reportes</div>
            </a>
        </div>

    </div>
</div>
@endsection
