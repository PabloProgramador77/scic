@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">
            
            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-portrait"></i> Clientes</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-4 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-portrait"></i> Clientes</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-3 my-2">
                <x-adminlte-button name="cliente" id="cliente" theme="primary" icon="fas fa-plus-circle" title=" Nuevo Cliente" data-toggle="modal" data-target="#modalNuevo" class="shadow" label=" Cliente"></x-adminlte-button>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 fw-semibold text-center bg-warning p-1 rounded">
                    <i class="fas fa-info-circle"></i>Elige un cliente para administrar sus cotizaciones o notas. De lo contrario pulsa el botón "<i class="fas fa-plus-circle"></i>Cliente" para registrar uno nuevo.<i class="fas fa-info-cirlce"></i>
                </p>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['N°', 'Cliente', 'Telefono', 'Correo Electrónico', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="cotizaciones" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $clientes ) > 0 )
                    @foreach ($clientes as $cliente)

                        <tr>
                            <td>{{ ($cliente->numero ? : 'N° Desconocido') }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ ($cliente->telefono ? : 'Sin telefono') }}</td>
                            <td>{{ ($cliente->email ? : 'Sin correo electrónico') }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-id="{{ $cliente->id }}" data-toggle="modal" data-target="#modalEditar" title="Editar cliente"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $cliente->id }}" data-value="{{ $cliente->nombre }}" title="Borrar cotización"></x-adminlte-button>
                                <a href="{{ url('/cotizaciones/cliente') }}/{{ $cliente->id}}" class="btn btn-secondary" title="Cotizaciones de cliente"><i class="fas fa-dollar-sign"></i></a>
                                <a href="{{ url('/notas/cliente') }}/{{ $cliente->id }}" class="btn btn-light" title="Notas de cliente"><i class="fas fa-file"></i></a>
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