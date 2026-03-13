@extends('layouts.app')

@section('title', 'Crear rol')

@section('content')
    <div class="card">
        <h1>Nuevo rol</h1>
        <p style="color:#64748b;">Sistema: <strong>{{ $sistema->nombre }}</strong></p>

        <form method="POST" action="{{ route('seg.sistemas.roles.store', $sistema) }}">
            @csrf

            @include('seg.roles.partials.form')

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('seg.sistemas.roles.index', $sistema) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection