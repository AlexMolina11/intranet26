@extends('layouts.app')

@section('title', 'Sistemas')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div>
                <h1 style="margin:0;">Sistemas</h1>
                <p style="margin:6px 0 0 0; color:#64748b;">Administración de sistemas internos</p>
            </div>

            <a href="{{ route('seg.sistemas.create') }}" class="btn btn-primary">Nuevo sistema</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Orden</th>
                    <th>Roles</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sistemas as $sistema)
                    <tr>
                        <td>{{ $sistema->id_sistema }}</td>
                        <td>{{ $sistema->codigo }}</td>
                        <td>{{ $sistema->nombre }}</td>
                        <td>{{ $sistema->slug }}</td>
                        <td>{{ $sistema->orden }}</td>
                        <td>{{ $sistema->roles_count }}</td>
                        <td>
                            @if ($sistema->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('seg.sistemas.edit', $sistema) }}" class="btn btn-warning">
                                    Editar
                                </a>

                                <a href="{{ route('seg.sistemas.roles.index', $sistema) }}" class="btn btn-secondary">
                                    Roles
                                </a>

                                <form method="POST" action="{{ route('seg.sistemas.toggle', $sistema) }}" class="inline-form">
                                    @csrf
                                    @method('PATCH')

                                    @if ($sistema->activo)
                                        <button type="submit" class="btn btn-danger">Desactivar</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Activar</button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No hay sistemas registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $sistemas->links() }}
        </div>
    </div>
@endsection