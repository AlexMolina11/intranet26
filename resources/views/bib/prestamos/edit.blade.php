@extends('layouts.app')

@section('title', 'Editar préstamo')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.prestamos.update', $prestamo) }}">
            @csrf
            @method('PUT')
            @include('bib.prestamos._form', ['prestamo' => $prestamo, 'soloLecturaPolitica' => false])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.prestamos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection