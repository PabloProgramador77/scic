@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-7">
                <h1 class="fs-3 fw-semibold my-2"><i class="fas fa-file-invoice-dollar"></i> Cotizador de {{ $cliente->nombre }}</h1>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-5 rounded shadow" title="Inicio"><i class="fas fa-home"></i></a>
                <a href="{{ url('/cotizaciones') }}" class="btn btn-secondary p-2 rounded text-white shadow" title="Clientes"><i class="fas fa-portrait"></i></a>
                <a href="{{ url('/cotizaciones/cliente') }}/{{ $cliente->id }}" class="btn btn-secondary p-2 rounded text-white shadow" title="Cotizaciones"><i class="fas fa-file"></i></a>
            </div>
            <div class="col-lg-12 my-2">
                <p class="fs-6 fw-semibold p-1 text-center bg-info"><i class="fas fa-info-circle"></i> Elige un modelo de la lista, posterior selecciona los materiales para pieza, continuar con los costos, consumibles y suelas.</p>
            </div>
            <div class="container-fluid row">
                <div class="col-lg-8 col-md-6 col-sm-12 d-flex align-items-center">
                    <x-adminlte-select2 class="flex-grow-1" id="modelo" name="modelo" label-class="info">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-secondary">
                                <i class="fas fa-socks"></i>
                            </div>
                        </x-slot>
                        @foreach($modelos as $modelo)
                            <option value="{{ $modelo->id }}">{{ $modelo->nombre }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input class="ms-2" name="total" id="total" value="0" readonly="true">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <x-adminlte-button id="costos" data-toggle="modal" data-target="#modalCostos" class="mx-4" theme="success" icon="fas fa-arrow-circle-right" label=" Continuar" disabled="true"></x-adminlte-button>
                </div>
            </div>
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['', 'Pieza', 'Material', 'Color', 'Largo y Alto', 'Piezas', 'Área', 'Cm2', 'Dm', 'Unidades', 'MtsxPar', 'Costo']
            @endphp

            <x-adminlte-datatable id="contenedorPiezas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $modelos ) > 0 )
                    <tr>
                        <td colspan="12" class="fw-bold text-danger">Sin modelo seleccionado. Elige uno por favor.</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="12" class="fw-semibold">No hay modelos registrados. Por favor, registralos en <a href="url('modelos')">este enlace.</a></td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

    </section>

    @include('cotizacion.costos')
    @include('cotizacion.costes')
    @include('cotizacion.consumible')
    @include('cotizacion.suelas')

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/modelo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costes.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/consumibles.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/suelas.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/asignar.js') }}" type="text/javascript"></script>

@stop