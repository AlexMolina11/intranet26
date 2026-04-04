@extends('layouts.app')

@section('title', 'Crear Disponibilidad')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.disponibilidades.store') }}">
            @csrf
            @include('bib.config.disponibilidades._form', ['disponibilidad' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.disponibilidades.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection