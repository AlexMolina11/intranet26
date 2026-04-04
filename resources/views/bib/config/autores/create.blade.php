@extends('layouts.app')

@section('title', 'Crear Autor')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Crear Autor</h1>
            <p class="page-subtitle">Registro de autor bibliográfico</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('bib.config.autores.store') }}">
            @csrf
            @include('bib.config.autores._form', ['autor' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.autores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection