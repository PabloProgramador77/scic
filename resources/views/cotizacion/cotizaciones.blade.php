@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">
            
            <div class="col-lg-7">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-file"></i> Cotizaciones de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-3 my-2">
                <a href="{{ url('/home') }}" class="btn btn-success p-2 mx-1 rounded"><i class="fas fa-home"></i> Inicio</a>
                <a href="{{ url('/cotizaciones') }}" class="btn p-2 mx-1 rounded text-white" style="background-color: teal;"><i class="fas fa-users"></i> Clientes</a>
            </div>
            <div class="col-lg-2 my-2">
                <a href="{{ url('/cotizador/cliente') }}/{{ $cliente->id }}" class="btn btn-primary p-2 mx-1 rounded"><i class="fas fa-plus-circle"></i> <b>Cotización</b></a>
                <x-adminlte-button class="p-2" id="nota" theme="primary" label=" Nota" icon="fas fa-plus-circle"></x-adminlte-button>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 fw-semibold text-center bg-warning p-1 rounded">
                    <i class="fas fa-info-circle"></i>Elige una cotización para gestionar. De lo contrario pulsa el botón "<i class="fas fa-plus-circle"></i>Cotización" para registrar una nueva.<i class="fas fa-info-cirlce"></i>
                </p>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['[ ]', 'Folio', 'Modelo', 'Precio Unitario', 'Estado', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="cotizaciones" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizaciones ) > 0 )
                    @foreach ($cotizaciones as $cotizacion)

                        <tr>
                            @if( $cotizacion->estado == 'Nota' )
                                <td><input type="checkbox" name="cotizacion" id="cotizacion" class="custom-checkbox" disabled="true" readonly="true"></td>
                            @else
                                <td><input type="checkbox" name="cotizacion" id="cotizacion" class="custom-checkbox" data-id="{{ $cotizacion->id }}"></td>
                            @endif
                            
                            <td>{{ $cotizacion->id }}</td>
                            <td>{{ $cotizacion->modelo->nombre }} - {{ $cotizacion->modelo->numero }}</td>
                            <td>$ {{ $cotizacion->precio }}</td>
                            <td>{{ $cotizacion->estado }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="secondary" data-id="{{ $cotizacion->id }}" title="Editar cotización"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $cotizacion->id }}" data-value="{{ $cotizacion->folio }}" title="Borrar cotización"></x-adminlte-button>
                                @if( $cotizacion->estado == 'Pendiente')
                                    <x-adminlte-button class="agregar" icon="fas fa-plus" theme="info" data-id="{{ $cotizacion->id }}" title="Agregar a nota" data-toggle="modal" data-target="#modalNotas"></x-adminlte-button>
                                @endif
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-danger">Sin cotizaciones registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('cotizacion.notas')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/nuevo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/cotizacion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/agregarCotizacion.js') }}" type="text/javascript"></script>

@stop