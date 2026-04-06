@extends('layouts.app')

@section('title', 'Editar ejemplar')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.ejemplares.update', $ejemplar) }}">
            @csrf
            @method('PUT')
            @include('bib.ejemplares._form', ['ejemplar' => $ejemplar])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.ejemplares.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection