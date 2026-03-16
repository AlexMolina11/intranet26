@extends('layouts.app')

@section('title', 'Crear área')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Crear área</h1>

        <form method="POST" action="{{ route('org.areas.store') }}">
            @csrf

            @include('org.areas._form')

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('org.areas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection