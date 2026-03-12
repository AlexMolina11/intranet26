@extends('layouts.app')

@section('title', 'Editar proyecto')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Editar proyecto</h1>

        <form method="POST" action="{{ route('org.proyectos.update', $proyecto) }}">
            @csrf
            @method('PUT')

            @include('org.proyectos._form', ['proyecto' => $proyecto])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('org.proyectos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection