@extends('layouts.app')

@section('title', 'Editar rol')

@section('content')
    <div class="card">
        <h1>Editar rol</h1>
        <p style="color:#64748b;">Sistema: <strong>{{ $sistema->nombre }}</strong></p>

        <form method="POST" action="{{ route('seg.sistemas.roles.update', [$sistema, $rol]) }}">
            @csrf
            @method('PUT')

            @include('seg.roles.partials.form', ['rol' => $rol])

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('seg.sistemas.roles.index', $sistema) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection