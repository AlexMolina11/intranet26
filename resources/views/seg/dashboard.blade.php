@extends('layouts.app')

@section('title', 'Dashboard Intranet')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard Intranet 2026</h1>
            <p class="page-subtitle">Resumen del sistema base de seguridad y organización</p>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="alert alert-info" style="margin:0;">
            Bienvenido, <strong>{{ $usuario->nombre_completo }}</strong>. Este dashboard resume el sistema base de la intranet y tu contexto organizacional actual.
        </div>
    </div>

    @if($accesosRapidos->isNotEmpty())
        <div class="card" style="margin-bottom:20px;">
            <div class="page-header" style="margin-bottom:16px;">
                <div class="page-header-text">
                    <h2 style="margin:0; font-size:20px;">Accesos rápidos</h2>
                    <p class="page-subtitle">Opciones disponibles según tus permisos</p>
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

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Usuarios activos</div>
            <div class="stat-value">{{ $usuariosActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Sistemas activos</div>
            <div class="stat-value">{{ $sistemasActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Roles activos</div>
            <div class="stat-value">{{ $rolesActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Permisos activos</div>
            <div class="stat-value">{{ $permisosActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Departamentos</div>
            <div class="stat-value">{{ $departamentosActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Proyectos</div>
            <div class="stat-value">{{ $proyectosActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Áreas</div>
            <div class="stat-value">{{ $areasActivas }}</div>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Mis áreas</h2>
                <p class="page-subtitle">Adscripción organizacional del usuario autenticado</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Departamento</th>
                        <th>Proyecto</th>
                        <th>Área</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($misAreas as $area)
                        <tr>
                            <td>{{ $area->departamento ?? '-' }}</td>
                            <td>{{ $area->proyecto ?? 'No aplica' }}</td>
                            <td>{{ $area->area ?? '-' }}</td>
                            <td>
                                @if($area->es_principal)
                                    <span class="badge">Principal</span>
                                @else
                                    <span class="badge">Secundaria</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">El usuario no tiene áreas asignadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Usuarios recientes</h2>
                <p class="page-subtitle">Últimos usuarios registrados en la intranet</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuariosRecientes as $item)
                        <tr>
                            <td>{{ $item->id_usuario }}</td>
                            <td>{{ $item->nombre_completo }}</td>
                            <td>{{ $item->correo }}</td>
                            <td>{{ $item->nombre_usuario }}</td>
                            <td>
                                @if($item->activo)
                                    <span class="badge">Activo</span>
                                @else
                                    <span class="badge">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection