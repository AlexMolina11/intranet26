@extends('layouts.app')

@section('title', 'Crear multa')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.multas.store') }}">
            @csrf
            @include('bib.multas._form', ['multa' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.multas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection