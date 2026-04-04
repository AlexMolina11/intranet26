@extends('layouts.app')

@section('title', 'Crear Editorial')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.editoriales.store') }}">
            @csrf
            @include('bib.config.editoriales._form', ['item' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.editoriales.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection