@extends('layouts.app')

@section('title', 'Editar Estado de ejemplar')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.estados-ejemplar.update', $estadoEjemplar) }}">
            @csrf
            @method('PUT')
            @include('bib.config.estados-ejemplar._form', ['estadoEjemplar' => $estadoEjemplar])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.estados-ejemplar.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection