@extends('layouts.app')

@section('title', 'Crear política de préstamo')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.politicas.store') }}">
            @csrf
            @include('bib.politicas._form', ['politica' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.politicas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection