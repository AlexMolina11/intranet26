@extends('layouts.app')

@section('title','Mostrador')

@section('content')

<div class="container">

    <div class="page-header">
        <h1>Mostrador</h1>
        <p class="text-muted">
            Atención diaria de usuarios en biblioteca.
        </p>
    </div>

    <div class="row">

        <div class="col-md-4">

            <div class="card">
                <div class="card-body">

                    <h3>Nuevo préstamo directo</h3>

                    <p>
                        Registrar un préstamo para un usuario presente.
                    </p>

                    <a
                        href="{{ route('bib.prestamos.create') }}"
                        class="btn btn-success btn-block">

                        Registrar préstamo

                    </a>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-body">

                    <h3>Entregas pendientes</h3>

                    <h2>{{ $pendientesEntrega }}</h2>

                    <a
                        href="{{ route('bib.prestamos.index') }}"
                        class="btn btn-primary btn-block">

                        Entregar préstamos

                    </a>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-body">

                    <h3>Préstamos activos</h3>

                    <h2>{{ $prestamosActivos }}</h2>

                    <a
                        href="{{ route('bib.prestamos.index') }}"
                        class="btn btn-primary btn-block">

                        Ver préstamos activos

                    </a>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection