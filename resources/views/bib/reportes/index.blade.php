@extends('layouts.app')

@section('title', 'Reportes Biblioteca')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Reportes Biblioteca</h1>
            <p class="page-subtitle">Consultas administrativas del módulo Biblioteca.</p>
        </div>
    </div>

    <div class="stats-grid">
        <a href="{{ route('bib.reportes.prestamos') }}" class="stat-card" style="text-decoration:none;">
            <div class="stat-title">Reporte de préstamos</div>
            <div class="stat-value">→</div>
        </a>

        <a href="{{ route('bib.reportes.multas') }}" class="stat-card" style="text-decoration:none;">
            <div class="stat-title">Reporte de multas</div>
            <div class="stat-value">→</div>
        </a>

        <a href="{{ route('bib.reportes.recursos-mas-prestados') }}" class="stat-card" style="text-decoration:none;">
            <div class="stat-title">Recursos más prestados</div>
            <div class="stat-value">→</div>
        </a>
    </div>
@endsection