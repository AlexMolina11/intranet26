@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard</h1>
            <p class="page-subtitle">Resumen general del sistema</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Usuarios</div>
            <div class="stat-value">{{ $usuariosCount ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Sistemas</div>
            <div class="stat-value">{{ $sistemasCount ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Roles</div>
            <div class="stat-value">{{ $rolesCount ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Permisos</div>
            <div class="stat-value">{{ $permisosCount ?? 0 }}</div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-top:0; color:#385506;">Accesos rápidos</h2>

        <div class="system-grid">
            <a href="{{ route('seg.usuarios.index') }}" class="system-card" style="text-decoration:none;">
                <strong>Usuarios</strong>
                <p style="margin:8px 0 0 0; color:#656264;">Administración de usuarios</p>
            </a>

            <a href="{{ route('seg.sistemas.index') }}" class="system-card" style="text-decoration:none;">
                <strong>Sistemas</strong>
                <p style="margin:8px 0 0 0; color:#656264;">Administración de sistemas</p>
            </a>

            <a href="{{ route('seg.permisos.index') }}" class="system-card" style="text-decoration:none;">
                <strong>Permisos</strong>
                <p style="margin:8px 0 0 0; color:#656264;">Administración de permisos</p>
            </a>
        </div>
    </div>
@endsection