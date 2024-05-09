@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-dollar-sign"></i> Cotizaciones</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-4 my-2">
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
            </div>
            <div class="col-lg-3 my-2">
                <x-adminlte-button name="nota" id="nota" theme="success" icon="fas fa-plus-circle" label=" Nota" data-toggle="modal" data-target="#modalNota"></x-adminlte-button>
                <a href="{{ url('/cotizador') }}" class="btn btn-primary mx-1 rounded"><i class="fas fa-dollar-sign"></i> Cotizador</a>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['', 'Folio', 'Modelo', 'Precio Unitario', 'Cliente', 'Estado', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="cotizaciones" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizaciones ) > 0 )
                    @foreach ($cotizaciones as $cotizacion)

                        <tr>
                            <td><input type="checkbox" name="cotizacion" id="cotizacion{{ $cotizacion->id }}" class="form-control" data-id="{{ $cotizacion->id }}" data-value="{{ $cotizacion->cliente->id }}"></td>
                            <td>{{ $cotizacion->id }}</td>
                            <td>{{ $cotizacion->modelo->nombre }}</td>
                            <td>$ {{ $cotizacion->precio }}</td>
                            <td>{{ $cotizacion->cliente->nombre }}</td>
                            <td title="Cotización pendiente para agregar a nota">{{ $cotizacion->estado }}</td>
                            <td>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $cotizacion->id }}" title="Borrar cotización"></x-adminlte-button>
                                <x-adminlte-button class="agregar" icon="fas fa-plus-circle" theme="primary" data-id="{{ $cotizacion->id }}" title="Agregar a nota" data-toggle="modal" data-target="#modalNotas"></x-adminlte-button>
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

    </section>

    @include('cotizacion.notas')

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/nuevo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/asignar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/cotizacion.js') }}" type="text/javascript"></script>

@stop