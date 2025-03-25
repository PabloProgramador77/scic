@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold my-2"><i class="fas fa-file-invoice-dollar"></i> Cotizador de {{ $cliente->nombre }}</h1>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
                <input type="hidden" name="cliente" id="cliente" value="{{ $cliente->nombre }}">
                <input type="hidden" name="ganancia" id="ganancia" value="{{ $modeloHasGanancia->ganancia }}">
                <input type="hidden" name="idCotizacion" id="idCotizacion" value="{{ $cotizacion->id }}">
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
                    <x-adminlte-select2 class="flex-grow-1" id="modelo" name="modelo" readonly="true" label-class="info">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-secondary">
                                <i class="fas fa-socks"></i>
                            </div>
                        </x-slot>
                        <option value="{{ $cotizacion->modelo->id }}" data-value="{{ $cotizacion->modelo->nombre }}, {{ $cotizacion->modelo->numero }}, {{ $cotizacion->modelo->horma }}">{{ $cotizacion->modelo->nombre }} {{ $cotizacion->modelo->numero }}</option>
                    </x-adminlte-select2>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-input class="mx-1" name="descripcion" id="descripcion" value="{{ $cotizacion->descripcion }}" readonly="true">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-2">
                    <x-adminlte-input class="mx-1" name="total" id="total" value="{{ $cotizacion->precio }}" readonly="true">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-success">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-4">
                    <x-adminlte-input class="mx-1" name="observaciones" id="observaciones" placeholder="Observaciones" value="{{ $cotizacion->observaciones }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 my-2">
                    <x-adminlte-button id="costos" data-toggle="modal" data-target="#modalCostos" class="mx-4" theme="success" icon="fas fa-arrow-circle-right" label=" Continuar"></x-adminlte-button>
                </div>
            </div>
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['', 'Pieza', 'Material', 'Color', 'Largo y Alto', 'Piezas', 'Área', 'Cm2', 'Dm', 'Unidades', 'MtsxPar', 'Costo'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [50], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="contenedorPiezas" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @foreach( $cotizacion->piezas as $pieza )
                    <tr>
                        <td>
                            <input type="checkbox" name="pieza" id="pieza{{ $pieza->id }}" class="custom-checkbox pieza" data-id="{{ $pieza->id }}" value="{{ $pieza->nombre }}, {{ $pieza->largo }}, {{ $pieza->alto }}, {{ $pieza->cantidad }}" checked>
                        </td>
                        <td>{{ $pieza->nombre }}</td>
                        <td>
                            <select name="material" id="material{{ $pieza->id }}" class="form-control material" data-id="{{ $pieza->id }}" value="{{ $pieza->nombre }}, {{ $pieza->cantidad }}, {{ $pieza->alto }}, {{ $pieza->largo }}">
                                <option value="{{ $pieza->materiales( $cotizacion->id )->first()->precio }}, {{ $pieza->materiales( $cotizacion->id )->first()->unidades }}, {{ $pieza->materiales( $cotizacion->id )->first()->id }}, {{ $pieza->materiales( $cotizacion->id )->first()->nombre }}, {{ $pieza->materiales( $cotizacion->id )->first()->concepto }}">{{ $pieza->materiales( $cotizacion->id )->first()->concepto }} {{ $pieza->materiales( $cotizacion->id )->first()->nombre }} : ${{ $pieza->materiales( $cotizacion->id )->first()->precio }}</option>
                                @foreach( $materiales as $material )
                                    @if(  $material->id != $pieza->materiales( $cotizacion->id )->first()->id )
                                        <option value="{{ $material->precio }}, {{ $material->unidades }}, {{ $material->id }}, {{ $material->nombre }}, {{ $material->concepto }}">{{ $material->concepto }} {{ $material->nombre }} : ${{ $material->precio }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="colorPieza" id="color{{ $pieza->id }}" class="form-control colorPieza{{ $pieza->id }}" data-id="{{ $pieza->id }}">
                                <option value="{{ $pieza->color( $cotizacion->id )->first()->color }}">{{ $pieza->color( $cotizacion->id )->first()->color }}</option>
                            </select>
                        </td>
                        <td class="medidas{{ $pieza->id }}">{{ $pieza->largo }} x {{ $pieza->alto }}</td>
                        <td class="cantidad{{ $pieza->id }}">{{ $pieza->cantidad }}</td>
                        <td class="area{{ $pieza->id }}">{{ number_format( ( $pieza->largo * $pieza->alto ), 1 ) }}</td>
                        <td class="cms{{ $pieza->id }}">{{ number_format( ( $pieza->largo * $pieza->alto ) * $pieza->cantidad, 1 ) }}</td>
                        <td class="dm{{ $pieza->id }}">{{ number_format( (( $pieza->largo * $pieza->alto ) * $pieza->cantidad)/100, 1 ) }}</td>
                        <td class="unidades{{ $pieza->id }}">{{ number_format( $pieza->materiales( $cotizacion->id )->first()->unidades , 1) }}</td>
                        <td class="mts{{ $pieza->id }}">{{ number_format( (( $pieza->largo*$pieza->alto )*( $pieza->cantidad )/( $pieza->materiales( $cotizacion->id )->first()->unidades*100 )) , 4) }}</td>
                        <td data-name="costo" class="costo{{ $pieza->id }}">{{ number_format( (( $pieza->largo*$pieza->alto )*( $pieza->cantidad )/( $pieza->materiales( $cotizacion->id )->first()->unidades*100 ))*( $pieza->materiales( $cotizacion->id )->first()->precio ) , 1 ) }}</td>
                    </tr>
                @endforeach

            </x-adminlte-datatable>

        </div>

    </section>

    @include('cotizacion.costos')
    @include('cotizacion.costes')
    @include('cotizacion.consumibles')
    @include('cotizacion.suela')
    @include('cotizacion.escritura')
    @include('cotizacion.previa')

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/edicion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costes.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/consumibles.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/suelasEdicion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/asignar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/guardar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/sobreescribir.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/preeliminarEdicion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/nuevaCotizacion.js') }}" type="text/javascript"></script>

@stop