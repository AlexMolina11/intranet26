@extends('layouts.app')

@section('title', 'Editar Disponibilidad')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.disponibilidades.update', $disponibilidad) }}">
            @csrf
            @method('PUT')
            @include('bib.config.disponibilidades._form', ['disponibilidad' => $disponibilidad])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.disponibilidades.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection