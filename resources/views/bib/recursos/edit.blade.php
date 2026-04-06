@extends('layouts.app')

@section('title', 'Editar recurso bibliográfico')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.recursos.update', $recurso) }}">
            @csrf
            @method('PUT')
            @include('bib.recursos._form', ['recurso' => $recurso])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.recursos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection