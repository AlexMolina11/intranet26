@extends('layouts.app')

@section('title', 'Mostrador Biblioteca')

@section('content')
@php
    $user = auth()->user();
    $canCrearPrestamo = $user->tienePermiso('BIB_PRESTAMOS_CREAR');
    $canGestionarPrestamo = $user->tienePermiso('BIB_PRESTAMOS_DEVOLVER');
    $canVerPrestamos = $user->tienePermiso('BIB_PRESTAMOS_VER');
@endphp
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

            <h1 class="bib-mode-title">Mostrador</h1>
            <div class="bib-mode-subtitle">
                Atención directa de usuarios: préstamos, entregas, devoluciones y renovaciones.
            </div>
        </div>

        <div class="row">

            @if($canCrearPrestamo)
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.prestamos.create') }}" class="bib-action-card">
                    <div class="bib-action-icon">📗</div>
                    <h2>Nuevo préstamo</h2>
                    <p>Registrar préstamo directo para un usuario presente.</p>
                    <div class="bib-action-footer">Registrar préstamo</div>
                </a>
            </div>
            @endif

            @if($canCrearPrestamo)
            <div class="col-lg-3 col-md-6 mb-4">
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
            </div>
            @endif

            @if($canGestionarPrestamo)
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.prestamos.index', ['estado' => 'ENTREGADO']) }}" class="bib-action-card">
                    <div class="bib-action-icon">↩️</div>
                    <h2>Devoluciones</h2>
                    <p>Buscar préstamos activos y registrar la devolución del ejemplar.</p>
                    <div class="bib-action-footer">Registrar devolución</div>
                </a>
            </div>
            @endif

            @if($canGestionarPrestamo)
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('bib.prestamos.index', ['estado' => 'ENTREGADO']) }}" class="bib-action-card">
                    <div class="bib-action-icon">🔄</div>
                    <h2>Renovaciones</h2>
                    <p>Revisar préstamos activos y renovar si la política lo permite.</p>
                    <div class="bib-action-footer">Gestionar renovaciones</div>
                </a>
            </div>
            @endif

        </div>

        <div class="row">

            @if($canVerPrestamos)
            <div class="col-lg-3 col-md-6 mb-4">
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
            @endif

            @if(! $canCrearPrestamo && ! $canGestionarPrestamo && ! $canVerPrestamos)
                <div class="col-12"><div class="card">No tienes acciones de mostrador asignadas.</div></div>
            @endif

        </div>

    </div>
</div>
@endsection