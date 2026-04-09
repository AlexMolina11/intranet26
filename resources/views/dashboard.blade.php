@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard principal</h1>
            <p class="page-subtitle">Portada general de la intranet</p>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="alert alert-info" style="margin:0;">
            Bienvenido, <strong>{{ $usuario->nombre }}</strong>. Aquí tienes un resumen general de tus accesos y de la plataforma.
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Sistemas autorizados</div>
            <div class="stat-value">{{ $sistemasAutorizadosCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Permisos efectivos</div>
            <div class="stat-value">{{ $permisosEfectivosCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Usuarios</div>
            <div class="stat-value">{{ $usuariosCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Sistemas</div>
            <div class="stat-value">{{ $sistemasCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Roles</div>
            <div class="stat-value">{{ $rolesCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Permisos</div>
            <div class="stat-value">{{ $permisosCount }}</div>
        </div>
    </div>

    @if($tarjetasSistema->isNotEmpty())
        <div class="card" style="margin-bottom:20px;">
            <div class="page-header" style="margin-bottom:16px;">
                <div class="page-header-text">
                    <h2 style="margin:0; font-size:20px;">Mis sistemas</h2>
                    <p class="page-subtitle">Accesos disponibles según tu perfil</p>
                </div>
            </div>

            <div class="system-grid">
                @foreach($tarjetasSistema as $sistema)
                    <a href="{{ $sistema['url'] }}" class="system-card" style="text-decoration:none;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <i class="{{ $sistema['icono'] ?: 'fa-solid fa-layer-group' }}" style="font-size:20px;"></i>
                            <div>
                                <strong>{{ $sistema['nombre'] }}</strong>
                                <p style="margin:8px 0 0 0; color:#656264;">
                                    {{ $sistema['descripcion'] ?: 'Ingresar al sistema' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if($accesosRapidos->isNotEmpty())
        <div class="card">
            <div class="page-header" style="margin-bottom:16px;">
                <div class="page-header-text">
                    <h2 style="margin:0; font-size:20px;">Accesos rápidos</h2>
                    <p class="page-subtitle">Opciones destacadas disponibles para tu usuario</p>
                </div>
            </div>

            <div class="page-header-actions">
                @foreach($accesosRapidos as $acceso)
                    <a href="{{ route($acceso['route']) }}" class="btn btn-primary">
                        <i class="{{ $acceso['icon'] }}"></i>
                        {{ $acceso['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection