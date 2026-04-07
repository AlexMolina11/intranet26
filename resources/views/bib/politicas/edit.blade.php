@extends('layouts.app')

@section('title', 'Editar política de préstamo')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.politicas.update', $politica) }}">
            @csrf
            @method('PUT')
            @include('bib.politicas._form', ['politica' => $politica])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.politicas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection