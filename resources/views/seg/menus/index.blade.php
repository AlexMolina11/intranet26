@extends('layouts.app')

@section('title', 'Menús')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Menús</h1>
                <p class="page-subtitle">Administración de menús del sistema</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('seg.menus.create') }}" class="btn btn-primary">Nuevo menú</a>
            </div>
        </div>

        <form method="GET" action="{{ route('seg.menus.index') }}" style="margin-bottom:20px;">
            <div class="form-group">
                <label class="form-label" for="id_sistema">Filtrar por sistema</label>
                <select name="id_sistema" id="id_sistema" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach ($sistemas as $sistema)
                        <option value="{{ $sistema->id_sistema }}" {{ (string) $sistemaId === (string) $sistema->id_sistema ? 'selected' : '' }}>
                            {{ $sistema->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sistema</th>
                        <th>Nombre</th>
                        <th>Icono</th>
                        <th>Orden</th>
                        <th>Visible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td>{{ $menu->id_menu }}</td>
                            <td>{{ $menu->sistema->nombre ?? 'N/A' }}</td>
                            <td>{{ $menu->nombre }}</td>
                            <td>{{ $menu->icono ?: 'Sin icono' }}</td>
                            <td>{{ $menu->orden }}</td>
                            <td>{{ $menu->visible ? 'Sí' : 'No' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('seg.menus.edit', $menu) }}" class="btn btn-warning">Editar</a>

                                    <form method="POST" action="{{ route('seg.menus.destroy', $menu) }}" class="inline-form"
                                        onsubmit="return confirm('¿Deseas eliminar este menú?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay menús registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $menus->links() }}
        </div>
    </div>
@endsection