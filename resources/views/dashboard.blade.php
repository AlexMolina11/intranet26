@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Dashboard</h1>
        <p style="color:#64748b; margin-bottom:0;">
            Bienvenido, {{ $usuario->nombre_completo }}.
        </p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Sistemas autorizados</div>
            <div class="stat-value">{{ $sistemas->count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Permisos efectivos</div>
            <div class="stat-value">{{ $totalPermisos }}</div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Mis sistemas</h2>

        <div class="system-grid">
            @forelse ($sistemas as $sistema)
                <div class="system-card">
                    <div style="display:flex; justify-content:space-between; gap:12px; align-items:flex-start;">
                        <strong>{{ $sistema->nombre }}</strong>
                        <span class="badge badge-success">Activo</span>
                    </div>

                    <p style="margin:10px 0 0 0; color:#64748b;">
                        {{ $sistema->descripcion ?: 'Sistema habilitado para tu usuario.' }}
                    </p>
                </div>
            @empty
                <p>No tienes sistemas autorizados.</p>
            @endforelse
        </div>
    </div>
@endsection