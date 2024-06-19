@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-8">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-dollar-sign"></i> Numeración de Nota</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-4 my-2">
                <a href="{{ url('/home') }}" class="btn btn-success p-2 mx-1 rounded"><i class="fas fa-home"></i> Inicio</a>
            </div>
        </div>

        <div class="container-fluid row p-1">
            <p class="col-lg-12 col-md-12 text-center bg-warning p-1 rounded fw-semibold"><i class="fas fa-info-circle"></i> A continuación, introduce la cantidad de pares de cada numeración y termina pulsando el bóton con el icono <i class="fas fa-save"></i></p>
            <x-adminlte-input class="col-lg-2" name="folio" id="folio" readonly="true" value="{{ $nota->id }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-file-invoice-dollar"></i> Folio
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
                <x-adminlte-button theme="primary" icon="fas fa-save" id="agregarNum"></x-adminlte-button>
            </div>
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Modelo', 'Precio Unitario', 'Numeraciones', 'Pares Totales', 'Monto'];
            @endphp

            <x-adminlte-datatable id="notas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

            @foreach ($nota->cotizaciones as $cotizacion)

                <tr>
                    <td>
                        <input type="hidden" name="cotizacion" id="cotizacion{{ $cotizacion->id }}" value="{{ $cotizacion->id }}">
                        {{ $cotizacion->modelo->nombre }} - {{ $cotizacion->modelo->numero }}
                    </td>
                    <td class="precio{{ $cotizacion->id }}">{{ $cotizacion->precio }}</td>
                    <td>
                        <div class="row">
                            @foreach ($cotizacion->modelo->numeraciones as $numeracion)
                                
                                <input type="number" name="numeracion" id="{{ $numeracion->id }}" data-id="{{ $cotizacion->id }}" class="text-center" placeholder="#{{ $numeracion->numero }}" value="{{ $numeracion->cantidad( $cotizacion->id, $numeracion->id ) }}">
                                
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

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/numeraciones.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/agregarNumeraciones.js') }}" type="text/javascript"></script>

@stop