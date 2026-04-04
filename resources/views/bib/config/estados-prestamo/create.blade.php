@extends('layouts.app')

@section('title', 'Crear Estado de préstamo')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.estados-prestamo.store') }}">
            @csrf
            @include('bib.config.estados-prestamo._form', ['estadoPrestamo' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.estados-prestamo.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection