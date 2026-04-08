@extends('layouts.app')

@section('title', 'Editar multa')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.multas.update', $multa) }}">
            @csrf
            @method('PUT')
            @include('bib.multas._form', ['multa' => $multa])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.multas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection