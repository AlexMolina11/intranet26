@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Editar usuario</h1>

        <form method="POST" action="{{ route('seg.usuarios.update', $usuario) }}">
            @csrf
            @method('PUT')

            @include('seg.usuarios._form', ['usuario' => $usuario])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection