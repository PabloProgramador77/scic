@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary">Modelos</h1>
                <p class="fs-6 fw-semibold text-secondary">Panel de Administrador</p>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'N°', 'Descripción', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="modelos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $modelos ) > 0 )
                    @foreach ($modelos as $modelo)

                        <tr>
                            <td>{{ $modelo->nombre }}</td>
                            <td>{{ $modelo->numero }}</td>
                            <td>{{ $modelo->descripcion }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $modelo->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $modelo->id }}"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin modelos registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('modelos.nuevo')
        @include('modelos.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/borrar.js') }}" type="text/javascript"></script>

@stop