@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-file-invoice-dollar"></i> Costes Neutros</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-1 rounded" title="Inicio"><i class="fas fa-home"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo coste"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'Descripción', 'Total', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="costes" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $costes ) > 0 )
                    @foreach ($costes as $coste)

                        <tr>
                            <td>{{ $coste->nombre }}</td>
                            <td>{{ $coste->descripcion }}</td>
                            <td>$ {{ $coste->monto }} MXN</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $coste->id }}" title="Editar coste"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $coste->id }}" title="Borrar coste"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin costos neutros registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('costes.nuevo')
        @include('costes.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costes/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costes/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costes/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/costes/borrar.js') }}" type="text/javascript"></script>

@stop