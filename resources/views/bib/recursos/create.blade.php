@extends('layouts.app')

@section('title', 'Crear recurso bibliográfico')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.recursos.store') }}">
            @csrf
            @include('bib.recursos._form', ['recurso' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.recursos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection