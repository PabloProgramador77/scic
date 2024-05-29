@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-dollar-sign"></i> Notas</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-4 my-2">
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
            </div>
            <div class="col-lg-3 my-2">
                <a href="{{ url('/cotizaciones') }}" class="btn btn-success mx-1 rounded"><i class="fas fa-plus"></i> Nota</a>
                <a href="{{ url('/cotizador') }}" class="btn btn-primary mx-1 rounded"><i class="fas fa-dollar-sign"></i> Cotizador</a>
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
                                <a href="{{ url('/nota/editar') }}/{{ $nota->id }}" class="btn btn-info editar"><i class="fas fa-edit"></i></a>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $nota->id }}" title="Borrar cotización"></x-adminlte-button>
                                <a href="{{ url('/nota/ver') }}/{{ $nota->id }}" class="btn btn-primary"><i class="fas fa-info-circle"></i></a>
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

@stop