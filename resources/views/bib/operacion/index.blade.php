@extends('layouts.app')

@section('title', 'Operación Biblioteca')

@section('content')
<style>
    .bib-operation-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 20px 0;
    }

    .bib-operation-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .bib-operation-header h1 {
        font-size: 30px;
        font-weight: 800;
        color: #385506;
        margin-bottom: 8px;
    }

    .bib-operation-header p {
        color: #656264;
        font-size: 15px;
        margin: 0;
    }

    .bib-operation-card {
        display: block;
        min-height: 220px;
        background: #ffffff;
        border: 1px solid #e8e8e8;
        border-radius: 20px;
        padding: 28px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
        transition: all .18s ease-in-out;
    }

    .bib-operation-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,.10);
        text-decoration: none;
        color: inherit;
    }

    .bib-operation-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #f1f5e8;
        color: #385506;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 18px;
    }

    .bib-operation-card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #385506;
        margin-bottom: 12px;
    }

    .bib-operation-card p {
        color: #656264;
        font-size: 15px;
        line-height: 1.45;
        margin-bottom: 18px;
    }

    .bib-operation-list {
        padding-left: 18px;
        margin: 0;
        color: #333;
        font-size: 14px;
        line-height: 1.7;
    }

    .bib-operation-footer {
        margin-top: 16px;
        font-size: 13px;
        font-weight: 700;
        color: #779123;
    }

    .bib-operation-alert {
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
    <div class="bib-operation-wrap">

        <div class="bib-operation-header">
            <h1>Operación Biblioteca</h1>
            <p>Selecciona el área de trabajo que deseas utilizar.</p>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.mostrador.index') }}" class="bib-operation-card">
                    <div class="bib-operation-icon">🏛️</div>

                    <h2>Mostrador</h2>

                    <p>
                        Para la atención diaria de usuarios en biblioteca.
                    </p>

                    <ul class="bib-operation-list">
                        <li>Nuevo préstamo directo</li>
                        <li>Entregas pendientes</li>
                        <li>Devoluciones</li>
                    </ul>

                    <div class="bib-operation-footer">
                        Ingresar a mostrador
                        @if($prestamosPendientesEntrega > 0)
                            <span class="bib-operation-alert">{{ $prestamosPendientesEntrega }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.solicitudes.panel') }}" class="bib-operation-card">
                    <div class="bib-operation-icon">📥</div>

                    <h2>Solicitudes</h2>

                    <p>
                        Para revisar y dar seguimiento a las solicitudes recibidas.
                    </p>

                    <ul class="bib-operation-list">
                        <li>Solicitudes pendientes</li>
                        <li>Solicitudes aprobadas</li>
                        <li>Solicitudes rechazadas</li>
                    </ul>

                    <div class="bib-operation-footer">
                        Ingresar a solicitudes
                        @if($solicitudesPendientes > 0)
                            <span class="bib-operation-alert">{{ $solicitudesPendientes }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.multas.panel') }}" class="bib-operation-card">
                    <div class="bib-operation-icon">💲</div>

                    <h2>Multas</h2>

                    <p>
                        Para administrar multas pendientes, pagadas o anuladas.
                    </p>

                    <ul class="bib-operation-list">
                        <li>Multas pendientes</li>
                        <li>Multas pagadas</li>
                        <li>Registro de pagos</li>
                    </ul>

                    <div class="bib-operation-footer">
                        Ingresar a multas
                        @if($multasPendientes > 0)
                            <span class="bib-operation-alert">{{ $multasPendientes }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.consultas.panel') }}" class="bib-operation-card">
                    <div class="bib-operation-icon">🔎</div>

                    <h2>Consultas</h2>

                    <p>
                        Para consultar catálogo, préstamos y reportes básicos.
                    </p>

                    <ul class="bib-operation-list">
                        <li>Consulta bibliográfica</li>
                        <li>Reportes básicos</li>
                        <li>Seguimiento de préstamos</li>
                    </ul>

                    <div class="bib-operation-footer">
                        Ingresar a consultas
                        @if($prestamosVencidos > 0)
                            <span class="bib-operation-alert">{{ $prestamosVencidos }}</span>
                        @endif
                    </div>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection