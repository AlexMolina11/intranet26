@extends('layouts.app')

@section('title', 'Biblioteca')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin: 0;">Biblioteca</h1>
                <p class="page-subtitle">Dashboard general del módulo bibliográfico</p>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <div class="alert alert-info" style="margin-bottom: 20px;">
                Bienvenido, <strong>{{ $usuario->nombre }}</strong>. Desde aquí podrás acceder a la configuración y operación del sistema de biblioteca.
            </div>

            <div class="stats-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                <div class="stat-card">
                    <div class="stat-label">Sistema</div>
                    <div class="stat-value">BIB</div>
                    <div class="stat-help">Biblioteca</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Permisos efectivos</div>
                    <div class="stat-value">{{ count($usuario->permisosEfectivosCodigos()) }}</div>
                    <div class="stat-help">Sobre todos los sistemas autorizados</div>
                </div>
            </div>
        </div>
    </div>

    @if($accesosRapidos->isNotEmpty())
        <div class="card" style="margin-top: 20px;">
            <div class="page-header">
                <div class="page-header-text">
                    <h2 style="margin: 0;">Accesos rápidos</h2>
                    <p class="page-subtitle">Atajos disponibles según tus permisos</p>
                </div>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-top:20px;">
                @foreach($accesosRapidos as $acceso)
                    <a href="{{ route($acceso['route']) }}"
                       class="card"
                       style="text-decoration:none; color:inherit; margin:0;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <i class="{{ $acceso['icon'] }}" style="font-size: 20px;"></i>
                            <div>
                                <div style="font-weight:600;">{{ $acceso['label'] }}</div>
                                <div class="page-subtitle">Ir a la sección</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection