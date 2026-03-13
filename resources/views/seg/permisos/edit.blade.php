@extends('layouts.app')

@section('title', 'Editar permiso')

@section('content')
    <div class="card">
        <h1>Editar permiso</h1>

        <form method="POST" action="{{ route('seg.permisos.update', $permiso) }}">
            @csrf
            @method('PUT')

            @include('seg.permisos.partials.form', ['permiso' => $permiso])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('seg.permisos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection