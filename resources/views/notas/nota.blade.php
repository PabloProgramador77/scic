@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-file"></i> Nota de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-5 my-2">
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
            <div class="col-lg-2">
                <a href="{{ url('/cotizador/cliente') }}/{{ $cliente->id }}" class="btn btn-primary rounded" title="Cotizador"><i class="fas fa-plus-circle"></i> Cotizador</a>
            </div>
        </div>

        <div class="container-fluid row p-1">
            <p class="col-lg-12 col-md-12 text-center bg-info p-1 rounded fs-6 fw-semibold"> 
                A continuación los datos generales de la nota, no es posible editar los datos. Para descargar la nota presiona el botón con el icono <i class="fas fa-download"></i> y para pasar a producción pulsa el botón con el icono <i class="fas fa-hand-holding-usd"></i>
            </p>
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
            <div class="col-lg-2 col-md-3 col-sm-4">
                <x-adminlte-button theme="primary" icon="fas fa-download" id="imprimirNota" data-id="{{ $nota->id }}" title="Descargar nota"></x-adminlte-button>
                @if( $nota->estado != 'Pagada' )
                    @if( $nota->estado == 'Pendiente' )
                        <x-adminlte-button theme="secondayr" icon="fas fa-hand-holding-usd" id="anticiparNota" data-id="{{ $nota->id }}" title="Pasar a producción"></x-adminlte-button>
                    @else
                        <x-adminlte-button theme="danger" icon="fas fa-ban" id="cerrarNota" data-id="{{ $nota->id }}" title="Cerrar nota"></x-adminlte-button>
                    @endif
                @endif
            
            </div>
            
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Modelo', 'Descripción', 'Precio Unitario', 'Numeraciones', 'Pares Totales', 'Monto'];
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

                        @foreach( $cotizacion->colores as $color )
                            {{ $color->pivot->colorMaterial.', ' }}
                        @endforeach

                    </td>
                    <td class="precio{{ $cotizacion->id }}">{{ $cotizacion->precio }}</td>
                    <td>
                        <div class="row">
                            @foreach ($cotizacion->modelo->numeraciones as $numeracion)
                                
                                <input type="number" name="numeracion" id="{{ $numeracion->id }}" data-id="{{ $cotizacion->id }}" class="col-lg-1 col-md-1 col-sm-1 text-center" readonly="true" value="{{ $numeracion->cantidad( $cotizacion->id, $numeracion->id ) }}">
                                
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
    <script src="{{ asset('js/notas/descarga.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/anticipar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/cerrar.js') }}" type="text/javascript"></script>

@stop