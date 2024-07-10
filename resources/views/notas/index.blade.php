@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-8">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-dollar-sign"></i> Notas de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-4 my-2">
                <a href="{{ url('/home') }}" class="btn btn-success p-2 mx-1 rounded"><i class="fas fa-home"></i> Inicio</a>
                <a href="{{ url('/cotizaciones/cliente') }}/{{ $cliente->id }}" class="btn mx-1 rounded" style="background-color: lime;"><i class="fas fa-file"></i> Cotizaciones</a>
                <a href="{{ url('/cotizador/cliente') }}/{{ $cliente->id }}" class="btn mx-1 rounded text-white" style="background-color: teal;"><i class="fas fa-dollar-sign"></i> Cotizador</a>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Folio', 'Cliente', 'Total de Nota', 'Estado', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="notas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $notas ) > 0 )
                    @foreach ($notas as $nota)

                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->cliente->nombre }}</td>
                            <td>$ {{ $nota->total }}</td>
                            <td>{{ $nota->estado }}</td>
                            <td>
                                @if( $nota->estado == 'Pendiente' )
                                    <a href="{{ url('/nota/editar') }}/{{ $nota->id }}/{{ $cliente->id }}" class="btn btn-info editar"><i class="fas fa-edit"></i></a>
                                    <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $nota->id }}" title="Borrar cotización"></x-adminlte-button>
                                @else
                                    <x-adminlte-button class="consumos" theme="secondary" icon="fas fa-square-root-alt" data-id="{{ $nota->id }}" title="Cálculo de Consumos"></x-adminlte-button>
                                @endif
                                <a href="{{ url('/nota/ver') }}/{{ $nota->id }}/{{ $cliente->id }}" class="btn btn-primary"><i class="fas fa-info-circle"></i></a>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin notas registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/borrarCotizacion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/calculoConsumo.js') }}" type="text/javascript"></script>

@stop