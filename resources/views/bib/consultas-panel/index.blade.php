@extends('layouts.app')

@section('title', 'Panel Consultas')

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
        background: #f1f5e8;
        color: #385506;
        border-radius: 999px;
        padding: 3px 8px;
        font-size: 12px;
        font-weight: 800;
    }

    .bib-alert-danger {
        background: #fee4e2;
        color: #b42318;
    }
</style>

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header">
            <a href="{{ route('bib.operacion.index') }}" class="bib-mode-back">
                ← Volver a Operación Biblioteca
            </a>

            <h1 class="bib-mode-title">Consultas</h1>
            <div class="bib-mode-subtitle">
                Consulta bibliográfica, reportes básicos y seguimiento operativo.
            </div>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.consulta.index') }}" class="bib-action-card">
                    <div class="bib-action-icon">🔎</div>
                    <h2>Consulta bibliográfica</h2>
                    <p>Buscar recursos disponibles en el catálogo de biblioteca.</p>
                    <div class="bib-action-footer">Buscar recursos</div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.prestamos.index') }}" class="bib-action-card">
                    <div class="bib-action-icon">📚</div>
                    <h2>Préstamos</h2>
                    <p>Consultar préstamos registrados, activos, vencidos o devueltos.</p>
                    <div class="bib-action-footer">
                        Ver préstamos
                        @if($recursosPrestados > 0)
                            <span class="bib-alert-count">{{ $recursosPrestados }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.multas.index') }}" class="bib-action-card">
                    <div class="bib-action-icon">👤</div>
                    <h2>Usuarios con multas</h2>
                    <p>Consultar usuarios que mantienen multas pendientes de pago.</p>
                    <div class="bib-action-footer">
                        Ver usuarios
                        @if($usuariosConMultas > 0)
                            <span class="bib-alert-count bib-alert-danger">{{ $usuariosConMultas }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.ejemplares.index') }}" class="bib-action-card">
                    <div class="bib-action-icon">⚠️</div>
                    <h2>Recursos dañados</h2>
                    <p>Consultar ejemplares marcados como dañados o fuera de servicio.</p>
                    <div class="bib-action-footer">
                        Ver dañados
                        @if($recursosDanados > 0)
                            <span class="bib-alert-count bib-alert-danger">{{ $recursosDanados }}</span>
                        @endif
                    </div>
                </a>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.reportes.index') }}" class="bib-action-card">
                    <div class="bib-action-icon">📊</div>
                    <h2>Reportes</h2>
                    <p>Acceder a reportes básicos de operación de biblioteca.</p>
                    <div class="bib-action-footer">Ver reportes</div>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection