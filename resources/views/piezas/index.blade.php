@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary">Piezas</h1>
                <p class="fs-6 fw-semibold text-secondary">Panel de Administrador</p>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'Alto y Largo', 'Descripción', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="piezas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $piezas ) > 0 )
                    @foreach ($piezas as $pieza)

                        <tr>
                            <td>{{ $pieza->nombre }}</td>
                            <td>{{ $pieza->alto }} x {{ $pieza->largo }}</td>
                            <td>
                                @if( $pieza->descripcion == NULL )
                                    Descripción desconocidad
                                @else
                                    {{ $pieza->descripcion }}
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $pieza->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $pieza->id }}"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin piezas registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('piezas.nuevo')
        @include('piezas.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/borrar.js') }}" type="text/javascript"></script>

@stop