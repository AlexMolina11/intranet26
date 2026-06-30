@extends('layouts.app')

@section('title', 'Panel Solicitudes')

@section('content')
<style>
    .bib-mode-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 20px 0;
    }

    .bib-mode-header {
        margin-bottom: 24px;
    }

    .bib-mode-back {
        display: inline-block;
        margin-bottom: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #779123;
        text-decoration: none;
    }

    .bib-mode-title {
        font-size: 30px;
        font-weight: 800;
        color: #385506;
        margin: 0;
    }

    .bib-mode-subtitle {
        color: #656264;
        margin-top: 6px;
        font-size: 15px;
    }

    .bib-action-card {
        display: block;
        min-height: 210px;
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        padding: 24px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 8px 22px rgba(0,0,0,.06);
        transition: all .18s ease-in-out;
    }

    .bib-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.10);
        text-decoration: none;
        color: inherit;
    }

    .bib-action-icon {
        font-size: 34px;
        margin-bottom: 14px;
    }

    .bib-action-card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #385506;
        margin-bottom: 10px;
    }

    .bib-action-card p {
        color: #656264;
        font-size: 14px;
        line-height: 1.45;
        margin-bottom: 12px;
    }

    .bib-action-footer {
        font-size: 13px;
        font-weight: 800;
        color: #779123;
    }

    .bib-alert-count {
        display: inline-block;
        margin-left: 6px;
        background: #fee4e2;
        color: #b42318;
        border-radius: 999px;
        padding: 3px 8px;
        font-size: 12px;
        font-weight: 800;
    }
</style>

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header">
            <a href="{{ route('bib.operacion.index') }}" class="bib-mode-back">
                ← Volver a Operación Biblioteca
            </a>

            <h1 class="bib-mode-title">Solicitudes</h1>
            <div class="bib-mode-subtitle">
                Revisión y seguimiento de solicitudes realizadas por usuarios finales.
            </div>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
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
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.solicitudes.index', ['estado' => 'APROBADA']) }}" class="bib-action-card">
                    <div class="bib-action-icon">✅</div>
                    <h2>Aprobadas</h2>
                    <p>Solicitudes aprobadas pendientes de convertirse en préstamo.</p>
                    <div class="bib-action-footer">
                        Ver aprobadas
                        @if($aprobadas > 0)
                            <span class="bib-alert-count">{{ $aprobadas }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.solicitudes.index', ['estado' => 'RECHAZADA']) }}" class="bib-action-card">
                    <div class="bib-action-icon">⛔</div>
                    <h2>Rechazadas</h2>
                    <p>Solicitudes que fueron denegadas con motivo registrado.</p>
                    <div class="bib-action-footer">
                        Ver rechazadas
                        @if($rechazadas > 0)
                            <span class="bib-alert-count">{{ $rechazadas }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.solicitudes.index', ['estado' => 'CANCELADA']) }}" class="bib-action-card">
                    <div class="bib-action-icon">🚫</div>
                    <h2>Canceladas</h2>
                    <p>Solicitudes canceladas por usuario o personal de biblioteca.</p>
                    <div class="bib-action-footer">
                        Ver canceladas
                        @if($canceladas > 0)
                            <span class="bib-alert-count">{{ $canceladas }}</span>
                        @endif
                    </div>
                </a>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.solicitudes.index') }}" class="bib-action-card">
                    <div class="bib-action-icon">📋</div>
                    <h2>Todas</h2>
                    <p>Consulta general de todas las solicitudes registradas.</p>
                    <div class="bib-action-footer">Ver todas</div>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection