@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-file"></i> Nota de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
                <input type="hidden" name="idNota" id="idNota" value="{{ $nota->id }}">
            </div>
            <div class="col-lg-6 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones"><i class="fas fa-portrait"></i> Clientes</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones/cliente/{{ $cliente->id }}"><i class="fas fa-file-invoice-dollar"></i> Cotizaciones de Cliente</a></li>
                        <li class="breadcrumb-item"><a href="/notas/cliente/{{ $cliente->id }}"><i class="fas fa-file"></i> Notas de Cliente</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-file"></i> Nota de Cliente</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-fluid row p-1">
            <p class="col-lg-12 col-md-12 text-center bg-info p-1 rounded fw-semibold"><i class="fas fa-info-circle"></i> A continuación, edita las cantidades de las numeraciones de la nota como consideres necesario, y termina pulsando el botón con el icono <i class="fas fa-save"></i></p>
            <div class="col-lg-2">
                <x-adminlte-input name="folio" id="folio" readonly="true" value="{{ $nota->id }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-sticky-note"></i> Folio
                            </div>
                        </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-4">
                <x-adminlte-input name="cliente" id="cliente" readonly="true" value="{{ $nota->cliente->nombre }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-user"></i> Cliente
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-2">
                <x-adminlte-input name="total" id="total" readonly="true" value="{{ $nota->total }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign"></i> Total
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-2">
                <x-adminlte-select name="dias" id="dias">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar"></i> 
                        </div>
                    </x-slot>
                    <option value="0">Días de entrega</option>
                    <option value="7">7 días</option>
                    <option value="14">14 días</option>
                    <option value="21">21 días</option>
                    <option value="30">30 días</option>
                </x-adminlte-select>
            </div>
            <div class="col-lg-2">
                <x-adminlte-button class="shadow mx-1" theme="secondary" icon="fas fa-truck-loading" id="impuestos" title=" Costo(s) extra y envio" data-toggle="modal" data-target="#modalImpuesto" data-id="{{ $nota->id }}"></x-adminlte-button>
                <x-adminlte-button class="shadow mx-1" theme="primary" icon="fas fa-save" id="agregarNum" title="Terminar nota"></x-adminlte-button>
            </div>
            
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $descripcion = '';

                $heads = ['Modelo', 'Descripción', 'Precio Unitario', 'Color', 'Descuento' ,'Numeraciones', 'Pares Totales', 'Monto'];
                $config = ['pageLength' => [100], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="notas" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

            @foreach ($nota->cotizaciones as $cotizacion)

                <tr>
                    <td>
                        <input type="hidden" name="cotizacion" id="cotizacion{{ $cotizacion->id }}" value="{{ $cotizacion->id }}">
                        {{ $cotizacion->modelo->nombre }} {{ $cotizacion->modelo->numero }}
                    </td>
                    <td>{{ $cotizacion->descripcion }}</td>
                    <td class="precio{{ $cotizacion->id }}">{{ $cotizacion->precio }}</td>
                    <td>{{ $cotizacion->color }}</td>
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