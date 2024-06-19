@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">
            
            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold "><i class="fas fa-users"></i> Cliente de Cotizaciones</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-4 my-2">
                <a href="{{ url('/home') }}" class="btn btn-success p-2 mx-1 rounded"><i class="fas fa-home"></i> Inicio</a>
            </div>
            <div class="col-lg-3 my-2">
                <x-adminlte-button name="cliente" id="cliente" theme="primary" icon="fas fa-plus-circle" label=" Cliente" data-toggle="modal" data-target="#modalNuevo"></x-adminlte-button>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 fw-semibold text-center bg-warning p-1 rounded">
                    <i class="fas fa-info-circle"></i>Elige un cliente para administrar sus cotizaciones o notas. De lo contrario pulsa el botón "<i class="fas fa-plus-circle"></i>Cliente" para registrar uno nuevo.<i class="fas fa-info-cirlce"></i>
                </p>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['N°', 'Cliente', 'Telefono', 'Correo Electrónico' ,'Domicilio', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="cotizaciones" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $clientes ) > 0 )
                    @foreach ($clientes as $cliente)

                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->domicilio }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="secondary" data-id="{{ $cliente->id }}" data-toggle="modal" data-target="#modalEditar" title="Editar cliente"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $cliente->id }}" data-value="{{ $cliente->nombre }}" title="Borrar cotización"></x-adminlte-button>
                                <a href="{{ url('/cotizaciones/cliente') }}/{{ $cliente->id}}" class="btn btn-info" title="Cotizaciones"><i class="fas fa-dollar-sign"></i></a>
                                <a href="{{ url('/notas/cliente') }}/{{ $cliente->id }}" class="btn btn-warning" title="Notas"><i class="fas fa-file"></i></a>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-info">Sin cotizaciones registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('clientes.nuevo')
        @include('clientes.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/clientes/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/clientes/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/clientes/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/clientes/borrar.js') }}" type="text/javascript"></script>

@stop