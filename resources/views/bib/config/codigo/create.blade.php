@extends('layouts.app')

@section('title', 'Crear ' . $singularTitle)

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Crear {{ $singularTitle }}</h1>
            <p class="page-subtitle">Registro de {{ strtolower($singularTitle) }}</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route($routePrefix . '.store') }}">
            @csrf
            @include('bib.config.codigo._form', ['item' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route($routePrefix . '.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection