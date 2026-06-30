@extends('layouts.app')

@section('title', 'Panel Multas')

@section('content')
@include('bib.partials._operation_styles')

<div class="container-fluid">
    <div class="bib-mode-wrap">

        <div class="bib-mode-header">
            <a href="{{ route('bib.operacion.index') }}" class="bib-mode-back">← Volver a Operación Biblioteca</a>
            <h1 class="bib-mode-title">Multas</h1>
            <div class="bib-mode-subtitle">Gestión de multas pendientes, pagadas y anuladas.</div>
        </div>

        <div class="bib-action-grid">
            <a href="{{ route('bib.multas.index', ['estado' => 'pendientes']) }}" class="bib-action-card">
                <div class="bib-action-icon">💲</div>
                <h2>Pendientes</h2>
                <p>Multas activas que aún no han sido pagadas por el usuario.</p>
                <div class="bib-action-footer">
                    Revisar pendientes
                    @if($pendientes > 0)
                        <span class="bib-alert-count">{{ $pendientes }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.multas.index', ['estado' => 'pagadas']) }}" class="bib-action-card">
                <div class="bib-action-icon">✅</div>
                <h2>Pagadas</h2>
                <p>Multas que ya fueron registradas como pagadas.</p>
                <div class="bib-action-footer">
                    Ver pagadas
                    @if($pagadas > 0)
                        <span class="bib-alert-count is-neutral">{{ $pagadas }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.multas.index', ['estado' => 'anuladas']) }}" class="bib-action-card">
                <div class="bib-action-icon">🚫</div>
                <h2>Anuladas</h2>
                <p>Multas desactivadas o anuladas administrativamente.</p>
                <div class="bib-action-footer">
                    Ver anuladas
                    @if($anuladas > 0)
                        <span class="bib-alert-count is-neutral">{{ $anuladas }}</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('bib.multas.create') }}" class="bib-action-card">
                <div class="bib-action-icon">➕</div>
                <h2>Registrar multa</h2>
                <p>Registrar una multa manual cuando aplique según la operación.</p>
                <div class="bib-action-footer">Nueva multa</div>
            </a>

            <a href="{{ route('bib.multas.index') }}" class="bib-action-card">
                <div class="bib-action-icon">📋</div>
                <h2>Todas</h2>
                <p>Consulta general de todas las multas registradas.</p>
                <div class="bib-action-footer">Ver todas</div>
            </a>
        </div>

    </div>
</div>
@endsection
