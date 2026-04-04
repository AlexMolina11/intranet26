@extends('layouts.app')

@section('title', 'Editar Etiqueta')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.etiquetas.update', $item) }}">
            @csrf
            @method('PUT')
            @include('bib.config.etiquetas._form', ['item' => $item])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.etiquetas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection