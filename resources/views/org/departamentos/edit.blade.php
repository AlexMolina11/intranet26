@extends('layouts.app')

@section('title', 'Editar departamento')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Editar departamento</h1>

        <form method="POST" action="{{ route('org.departamentos.update', $departamento) }}">
            @csrf
            @method('PUT')

            @include('org.departamentos._form', ['departamento' => $departamento])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('org.departamentos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection