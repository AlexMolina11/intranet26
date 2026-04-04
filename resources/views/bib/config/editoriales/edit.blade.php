@extends('layouts.app')

@section('title', 'Editar Editorial')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.editoriales.update', $item) }}">
            @csrf
            @method('PUT')
            @include('bib.config.editoriales._form', ['item' => $item])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.editoriales.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection