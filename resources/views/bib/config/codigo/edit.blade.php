@extends('layouts.app')

@section('title', 'Editar ' . $singularTitle)

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editar {{ $singularTitle }}</h1>
            <p class="page-subtitle">Actualización de {{ strtolower($singularTitle) }}</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route($routePrefix . '.update', $item) }}">
            @csrf
            @method('PUT')
            @include('bib.config.codigo._form', ['item' => $item])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route($routePrefix . '.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection