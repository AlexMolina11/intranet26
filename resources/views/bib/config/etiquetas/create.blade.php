@extends('layouts.app')

@section('title', 'Crear Etiqueta')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.etiquetas.store') }}">
            @csrf
            @include('bib.config.etiquetas._form', ['item' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.etiquetas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection