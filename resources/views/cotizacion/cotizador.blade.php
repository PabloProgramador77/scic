@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold my-2"><i class="fas fa-file-invoice-dollar"></i> Cotizador de {{ $cliente->nombre }}</h1>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
                <input type="hidden" name="cliente" id="cliente" value="{{ $cliente->nombre }}">
                <input type="hidden" name="ganancia" id="ganancia" value="{{ $modeloHasGanancia->ganancia }}">
            </div>
            <div class="col-lg-6 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones"><i class="fas fa-portrait"></i> Clientes</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones/cliente/{{ $cliente->id }}"><i class="fas fa-file-invoice-dollar"></i> Cotizaciones de Cliente</a></li>
                        <li class="breadcrumb-item"><a href="/notas/cliente/{{ $cliente->id }}"><i class="fas fa-file"></i> Notas de Cliente</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-file"></i> Cotizador</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-12 my-2">
                <p class="fs-6 fw-semibold p-1 text-center bg-info"><i class="fas fa-info-circle"></i> Elige un modelo de la lista, posterior selecciona los materiales para pieza, continuar con los costos, consumibles y suelas.</p>
            </div>
            <div class="container-fluid row">
                <div class="col-lg-2 col-md-6 col-sm-12 d-flex align-items-center">
                    <x-adminlte-select2 class="flex-grow-1" id="modelo" name="modelo" label-class="info">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-secondary">
                                <i class="fas fa-socks"></i>
                            </div>
                        </x-slot>
                            <option value="default">Elige un modelo</option>
                        @foreach($modelos as $modelo)
                            <option value="{{ $modelo->id }}" data-value="{{ $modelo->nombre }}, {{ $modelo->numero }}, {{ $modelo->horma }}">{{ $modelo->nombre }} {{ $modelo->numero }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-input class="mx-1" name="descripcion" id="descripcion" value="" readonly="true">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-2">
                    <x-adminlte-input class="mx-1" name="total" id="total" value="0" readonly="true">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-4">
                    <x-adminlte-input class="mx-1" name="observaciones" id="observaciones" placeholder="Observaciones">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 my-2">
                    <x-adminlte-button id="costos" data-toggle="modal" data-target="#modalCostos" class="mx-4" theme="success" icon="fas fa-arrow-circle-right" label=" Continuar" disabled="true"></x-adminlte-button>
                </div>
            </div>
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['', 'Pieza', 'Material', 'Color', 'Largo y Alto', 'Piezas', 'Área', 'Cm2', 'Dm', 'Unidades', 'MtsxPar', 'Costo'];
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
    @include('cotizacion.escritura')
    @include('cotizacion.preeliminar')

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/modelo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costes.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/consumibles.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/suelas.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/asignar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/guardar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/sobreescribir.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/preeliminar.js') }}" type="text/javascript"></script>

@stop