@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-hashtag"></i> Numeraciones</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-1 rounded" title="Inicio"><i class="fas fa-home"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nueva numeración"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['#', 'Numeración', 'Acciones'];
                $config = ['order' => [[1, 'asc']]];
            @endphp

            <x-adminlte-datatable id="numeraciones" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $numeraciones ) > 0 )
                    @foreach ($numeraciones as $numeracion)

                        <tr>
                            <td>{{ $numeracion->id }}</td>
                            <td>{{ number_format( $numeracion->numero, 1)  }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $numeracion->id }}" title="Editar numeración"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $numeracion->id }}" data-value="{{ $numeracion->numero }}" title="Borrar numeración"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin numeraciones registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('numeraciones.nuevo')
        @include('numeraciones.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/numeraciones/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/numeraciones/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/numeraciones/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/numeraciones/borrar.js') }}" type="text/javascript"></script>

@stop