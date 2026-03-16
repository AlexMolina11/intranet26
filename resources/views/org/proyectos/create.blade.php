@extends('layouts.app')

@section('title', 'Crear proyecto')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Crear proyecto</h1>

        <form method="POST" action="{{ route('org.proyectos.store') }}">
            @csrf

            @include('org.proyectos._form')

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('org.proyectos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection