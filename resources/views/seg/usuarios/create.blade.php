@extends('layouts.app')

@section('title', 'Crear usuario')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Crear usuario</h1>

        <form method="POST" action="{{ route('seg.usuarios.store') }}">
            @csrf

            @include('seg.usuarios._form')

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection