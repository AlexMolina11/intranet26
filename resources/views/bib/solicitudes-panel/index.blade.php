@extends('layouts.app')

@section('title', 'Panel Solicitudes')

@section('content')
@include('bib.partials._operation_styles')

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header">
            <a href="{{ route('bib.operacion.index') }}" class="bib-mode-back">← Volver a Operación Biblioteca</a>
            <h1 class="bib-mode-title">Solicitudes</h1>
            <div class="bib-mode-subtitle">Revisión y seguimiento de solicitudes realizadas por usuarios finales.</div>
        </div>

        <div class="bib-action-grid">
            <a href="{{ route('bib.solicitudes.index', ['estado' => 'PENDIENTE']) }}" class="bib-action-card">
                <div class="bib-action-icon">📥</div>
                <h2>Pendientes</h2>
                <p>Solicitudes nuevas que necesitan revisión del bibliotecario.</p>
                <div class="bib-action-footer">
                    Revisar pendientes
                    @if($pendientes > 0)
                        <span class="bib-alert-count">{{ $pendientes }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.solicitudes.index', ['estado' => 'APROBADA']) }}" class="bib-action-card">
                <div class="bib-action-icon">✅</div>
                <h2>Aprobadas</h2>
                <p>Solicitudes aprobadas pendientes de convertirse en préstamo.</p>
                <div class="bib-action-footer">
                    Ver aprobadas
                    @if($aprobadas > 0)
                        <span class="bib-alert-count is-neutral">{{ $aprobadas }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.solicitudes.index', ['estado' => 'RECHAZADA']) }}" class="bib-action-card">
                <div class="bib-action-icon">⛔</div>
                <h2>Rechazadas</h2>
                <p>Solicitudes que fueron denegadas con motivo registrado.</p>
                <div class="bib-action-footer">
                    Ver rechazadas
                    @if($rechazadas > 0)
                        <span class="bib-alert-count is-neutral">{{ $rechazadas }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.solicitudes.index', ['estado' => 'CANCELADA']) }}" class="bib-action-card">
                <div class="bib-action-icon">🚫</div>
                <h2>Canceladas</h2>
                <p>Solicitudes canceladas por usuario o personal de biblioteca.</p>
                <div class="bib-action-footer">
                    Ver canceladas
                    @if($canceladas > 0)
                        <span class="bib-alert-count is-neutral">{{ $canceladas }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.solicitudes.index') }}" class="bib-action-card">
                <div class="bib-action-icon">📋</div>
                <h2>Todas</h2>
                <p>Consulta general de todas las solicitudes registradas.</p>
                <div class="bib-action-footer">Ver todas</div>
            </a>
        </div>

    </div>
</div>
@endsection
