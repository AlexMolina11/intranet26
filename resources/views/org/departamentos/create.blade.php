@extends('layouts.app')

@section('title', 'Crear departamento')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Crear departamento</h1>

        <form method="POST" action="{{ route('org.departamentos.store') }}">
            @csrf

            @include('org.departamentos._form')

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('org.departamentos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection