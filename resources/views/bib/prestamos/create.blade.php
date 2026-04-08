@extends('layouts.app')

@section('title', 'Crear préstamo')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.prestamos.store') }}">
            @csrf
            @include('bib.prestamos._form', ['prestamo' => null, 'soloLecturaPolitica' => true])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.prestamos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection