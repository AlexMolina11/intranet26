@extends('layouts.app')

@section('title', 'Editar sistema')

@section('content')
    <div class="card">
        <h1>Editar sistema</h1>

        <form method="POST" action="{{ route('seg.sistemas.update', $sistema) }}">
            @csrf
            @method('PUT')

            @include('seg.sistemas.partials.form', ['sistema' => $sistema])

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('seg.sistemas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection