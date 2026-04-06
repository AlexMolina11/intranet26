@extends('layouts.app')

@section('title', 'Crear ejemplar')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.ejemplares.store') }}">
            @csrf
            @include('bib.ejemplares._form', ['ejemplar' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.ejemplares.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection