@extends('layouts.app')

@section('title', 'Editar Autor')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editar Autor</h1>
            <p class="page-subtitle">Actualización de autor bibliográfico</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('bib.config.autores.update', $autor) }}">
            @csrf
            @method('PUT')
            @include('bib.config.autores._form', ['autor' => $autor])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.autores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection