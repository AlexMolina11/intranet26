@extends('layouts.app')

@section('title', 'Submenús y opciones')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div>
                <h1 style="margin:0;">Submenús y opciones</h1>
                <p style="margin:6px 0 0 0; color:#64748b;">Administración de opciones de navegación</p>
            </div>

            <a href="{{ route('seg.menu-items.create') }}" class="btn btn-primary">Nueva opción</a>
        </div>

        <form method="GET" action="{{ route('seg.menu-items.index') }}" style="margin-bottom:20px; display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div class="form-group">
                <label class="form-label" for="id_sistema">Sistema</label>
                <select name="id_sistema" id="id_sistema" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach ($sistemas as $sistema)
                        <option value="{{ $sistema->id_sistema }}" {{ (string) $sistemaId === (string) $sistema->id_sistema ? 'selected' : '' }}>
                            {{ $sistema->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="id_menu">Menú</label>
                <select name="id_menu" id="id_menu" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id_menu }}" {{ (string) $menuId === (string) $menu->id_menu ? 'selected' : '' }}>
                            {{ $menu->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sistema</th>
                    <th>Menú</th>
                    <th>Padre</th>
                    <th>Nombre</th>
                    <th>Ruta</th>
                    <th>Orden</th>
                    <th>Permiso</th>
                    <th>Visible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->id_menu_item }}</td>
                        <td>{{ $item->sistema->nombre ?? 'N/A' }}</td>
                        <td>{{ $item->menu->nombre ?? 'N/A' }}</td>
                        <td>{{ $item->padre->nombre ?? 'Principal' }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->ruta }}</td>
                        <td>{{ $item->orden }}</td>
                        <td>{{ $item->permiso_requerido ?: 'Sin permiso' }}</td>
                        <td>{{ $item->visible ? 'Sí' : 'No' }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('seg.menu-items.edit', $item) }}" class="btn btn-warning">Editar</a>

                                <form method="POST" action="{{ route('seg.menu-items.destroy', $item) }}" class="inline-form"
                                    onsubmit="return confirm('¿Deseas eliminar esta opción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No hay opciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $items->links() }}
        </div>
    </div>
@endsection