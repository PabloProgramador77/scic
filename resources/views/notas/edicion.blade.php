@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-8">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-file"></i> Nota de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
                <input type="hidden" name="idNota" id="idNota" value="{{ $nota->id }}">
            </div>
            <div class="col-lg-4 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-5 rounded" title="Inicio"><i class="fas fa-home"></i></a>
            </div>
        </div>

        <div class="container-fluid row p-1">
            <p class="col-lg-12 col-md-12 text-center bg-info p-1 rounded fw-semibold"><i class="fas fa-info-circle"></i> A continuación, edita las cantidades de las numeraciones de la nota como consideres necesario, y termina pulsando el botón con el icono <i class="fas fa-save"></i></p>
            <x-adminlte-input class="col-lg-2" name="folio" id="folio" readonly="true" value="{{ $nota->id }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-sticky-note"></i> Folio
                        </div>
                    </x-slot>
            </x-adminlte-input>
            <x-adminlte-input class="col-lg-7" name="cliente" id="cliente" readonly="true" value="{{ $nota->cliente->nombre }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-info">
                        <i class="fas fa-user"></i> Cliente
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input class="col-lg-5" name="total" id="total" readonly="true" value="{{ $nota->total }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-info">
                        <i class="fas fa-dollar-sign"></i> Total
                    </div>
                </x-slot>
            </x-adminlte-input>
            <div class="col-lg-1">
                <x-adminlte-button theme="primary" icon="fas fa-save" id="agregarNum" title="Terminar nota"></x-adminlte-button>
            </div>
            <div class="col-lg-2">
                <x-adminlte-button theme="secondary" icon="fas fa-truck-loading" id="impuestos" title=" Costo(s) extra y envio" data-toggle="modal" data-target="#modalImpuesto" data-id="{{ $nota->id }}"></x-adminlte-button>
            </div>
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $descripcion = '';

                $heads = ['Modelo', 'Descripción', 'Precio Unitario', 'Descuento' ,'Numeraciones', 'Pares Totales', 'Monto'];
            @endphp

            <x-adminlte-datatable id="notas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

            @foreach ($nota->cotizaciones as $cotizacion)

                <tr>
                    <td>
                        <input type="hidden" name="cotizacion" id="cotizacion{{ $cotizacion->id }}" value="{{ $cotizacion->id }}">
                        {{ $cotizacion->modelo->nombre }} {{ $cotizacion->modelo->numero }}
                    </td>
                    <td>
                        @foreach( $cotizacion->consumibles as $consumible )
                            {{ $consumible->nombre.', '}}
                        @endforeach

                        @foreach( $cotizacion->suelas as $suela)
                            {{ $suela->nombre.', ' }}
                        @endforeach

                    </td>
                    <td class="precio{{ $cotizacion->id }}">{{ $cotizacion->precio }}</td>
                    <td class="descuento{{ $cotizacion->id }}"><input type="textbox" name="descuento" class="text-center col-lg-6 col-md-6 col-sm-6" placeholder="Descuento por par" value="{{ $nota->descuento( $nota->id, $cotizacion->id ) }}" id="{{ $nota->id }}" data-id="{{ $cotizacion->id }}" data-value="{{ $cotizacion->precio }}"></input></td>
                    <td>
                        <div class="row">
                            @foreach ($cotizacion->modelo->numeraciones as $numeracion)
                                
                                <input type="number" name="numeracion" id="{{ $numeracion->id }}" data-id="{{ $cotizacion->id }}" class="col-lg-1 col-md-1 col-sm-1 text-center" placeholder="#{{ $numeracion->numero }}" value="{{ $numeracion->cantidad( $cotizacion->id, $numeracion->id ) }}">
                                
                            @endforeach
                        </div>
                    </td>
                    <td class="pares{{ $cotizacion->id }}" >
                        <input class="bg-info border-0 text-center col-lg-12 col-md-12 col-sm-12 monto" type="text" name="pares" id="{{ $nota->id }}" data-id="{{ $cotizacion->id }}" value="{{ $nota->pares( $nota->id, $cotizacion->id ) }}" readonly="true">
                    </td>
                    <td class="total{{ $cotizacion->id }}" >
                        <input class="bg-success border-0 text-center col-lg-12 col-md-12 col-sm-12 monto" type="text" name="subtotal" id="{{ $nota->id }}" data-id="{{ $cotizacion->id }}" value="{{ $nota->monto( $nota->id, $cotizacion->id ) }}" readonly="true">
                    </td>
                </tr>

            @endforeach

            </x-adminlte-datatable>

        </div>

        @include('notas.impuestos')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/numeraciones.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/agregarNumeraciones.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/impuestos.js') }}" type="text/javascript"></script>

@stop