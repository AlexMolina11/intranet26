@extends('layouts.app')

@section('title', 'Operación Biblioteca')

@section('content')
@include('bib.partials._operation_styles')

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header is-centered">
            <h1 class="bib-mode-title">Operación Biblioteca</h1>
            <div class="bib-mode-subtitle">Selecciona el área de trabajo que deseas utilizar.</div>
        </div>

        <div class="bib-action-grid">
            <a href="{{ route('bib.mostrador.index') }}" class="bib-action-card">
                <div class="bib-action-icon">🏛️</div>
                <h2>Mostrador</h2>
                <p>Para la atención diaria de usuarios en biblioteca.</p>
                <ul class="bib-action-list">
                    <li>Nuevo préstamo directo</li>
                    <li>Entregas pendientes</li>
                    <li>Devoluciones</li>
                </ul>
                <div class="bib-action-footer">
                    Ingresar a mostrador
                    @if($prestamosPendientesEntrega > 0)
                        <span class="bib-alert-count">{{ $prestamosPendientesEntrega }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.solicitudes.panel') }}" class="bib-action-card">
                <div class="bib-action-icon">📥</div>
                <h2>Solicitudes</h2>
                <p>Para revisar y dar seguimiento a las solicitudes recibidas.</p>
                <ul class="bib-action-list">
                    <li>Solicitudes pendientes</li>
                    <li>Solicitudes aprobadas</li>
                    <li>Solicitudes rechazadas</li>
                </ul>
                <div class="bib-action-footer">
                    Ingresar a solicitudes
                    @if($solicitudesPendientes > 0)
                        <span class="bib-alert-count">{{ $solicitudesPendientes }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.multas.panel') }}" class="bib-action-card">
                <div class="bib-action-icon">💲</div>
                <h2>Multas</h2>
                <p>Para administrar multas pendientes, pagadas o anuladas.</p>
                <ul class="bib-action-list">
                    <li>Multas pendientes</li>
                    <li>Multas pagadas</li>
                    <li>Registro de pagos</li>
                </ul>
                <div class="bib-action-footer">
                    Ingresar a multas
                    @if($multasPendientes > 0)
                        <span class="bib-alert-count">{{ $multasPendientes }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.consultas.panel') }}" class="bib-action-card">
                <div class="bib-action-icon">🔎</div>
                <h2>Consultas</h2>
                <p>Para consultar catálogo, préstamos y reportes básicos.</p>
                <ul class="bib-action-list">
                    <li>Consulta bibliográfica</li>
                    <li>Reportes básicos</li>
                    <li>Seguimiento de préstamos</li>
                </ul>
                <div class="bib-action-footer">
                    Ingresar a consultas
                    @if($prestamosVencidos > 0)
                        <span class="bib-alert-count">{{ $prestamosVencidos }}</span>
                    @endif
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
