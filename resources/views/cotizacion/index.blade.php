@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-dollar-sign"></i> Cotizaciones</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <a href="{{ url('/cotizador') }}" class="btn btn-primary mx-1 rounded"><i class="fas fa-dollar-sign"></i> Cotizador</a>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Folio', 'Modelo', 'Precio Unitario', 'Estado', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="cotizaciones" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizaciones ) > 0 )
                    @foreach ($cotizaciones as $cotizacion)

                        <tr>
                            <td>{{ $cotizacion->id }}</td>
                            <td>{{ $cotizacion->modelo->nombre }}</td>
                            <td>$ {{ $cotizacion->precio }}</td>
                            <td>{{ $cotizacion->estado }}</td>
                            <td>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $cotizacion->id }}"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin cotizaciones registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>

@stop