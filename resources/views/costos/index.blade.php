@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-file-invoice-dollar"></i> Costos</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'Tipo', 'Total', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="costos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $costos ) > 0 )
                    @foreach ($costos as $costo)

                        <tr>
                            <td>{{ $costo->nombre }}</td>
                            <td>{{ $costo->tipo }}</td>
                            <td>$ {{ $costo->total }} MXN</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $costo->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $costo->id }}"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin costos registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('costos.nuevo')
        @include('costos.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costos/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costos/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costos/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costos/borrar.js') }}" type="text/javascript"></script>

@stop