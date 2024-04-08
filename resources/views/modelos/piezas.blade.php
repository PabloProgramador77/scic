@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-cogs"></i> Configuración de Modelo</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-4 my-2">
                <x-adminlte-input name="nombreModelo" id="nombreModelo" readonly="true" value="{{ $modelo->nombre }} - {{ $modelo->numero }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <input type="hidden" name="idModelo" id="idModelo" value="{{ $modelo->id }}">
            </div>
            <div class="col-lg-2 my-2">
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalPieza" icon="fas fa-socks"></x-adminlte-button>
                <x-adminlte-button theme="secondary" data-toggle="modal" data-target="#modalCosto" icon="fas fa-dollar-sign" data-value="{{ $modelo->nombre }}" data-id="{{ $modelo->id }}" class="costos"></x-adminlte-button>
                <x-adminlte-button theme="warning" data-toggle="modal" data-target="#modalConsumible" icon="fas fa-dollar-sign" data-value="{{ $modelo->nombre }}" data-id="{{ $modelo->id }}" class="consumibles"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">

            @php
                $heads = ['Pieza', 'Alto x Largo', 'Cantidad de Piezas', 'Descripción', '']
            @endphp
            <x-adminlte-datatable id="piezas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $piezas ) > 0 )
                
                    @foreach( $piezas as $pieza )
                    
                        <tr>
                            <td>{{ $pieza->nombre }}</td>
                            <td>{{ $pieza->alto }} X {{ $pieza->largo }}</td>
                            <td>{{ $pieza->cantidad }}</td>
                            @if( $pieza->descripcion == NULL )
                                <td>Descripción desconocida</td>
                            @else
                                <td>{{ $pieza->descripcion }}</td>
                            @endif
                            
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $pieza->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $pieza->id }}"></x-adminlte-button>
                            </td>
                        </tr>

                    @endforeach

                @else

                    <tr>
                        <td colspan="5" class="text-center text-danger"><i class="fas fa-info-circle"></i> Sin piezas registradas en el modelo</td>
                    </tr>

                @endif

            </x-adminlte-datatable>

        </div>

        @include('modelos.piezas.nuevo')
        @include('modelos.piezas.editar')
        @include('modelos.costos.costo')
        @include('modelos.consumible.consumible')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/piezas.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/costos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/piezas/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/agregarCostos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/consumible.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/agregarConsumibles.js') }}" type="text/javascript"></script>

@stop