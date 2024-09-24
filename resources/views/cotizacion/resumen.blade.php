@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">
            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold my-2"><i class="fas fa-info-circle"></i> Resumen de Cotización</h1>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cotizacion->cliente->id }}">
            </div>
            <div class="col-lg-7 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones"><i class="fas fa-portrait"></i> Clientes</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones/cliente/{{ $cotizacion->cliente->id }}"><i class="fas fa-file-invoice-dollar"></i> Cotizaciones de Cliente</a></li>
                        <li class="breadcrumb-item"><a href="/notas/cliente/{{ $cotizacion->cliente->id }}"><i class="fas fa-file"></i> Notas de Cliente</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-info-circle"></i> Resumen de Cotización</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 my-2">
                <a href="{{ url('/cotizador/cliente') }}/{{ $cotizacion->cliente->id }}" class="btn btn-primary p-2 mx-1 rounded" title="Nueva cotización"><i class="fas fa-plus-circle"></i> <b>Cotizador</b></a>
                <x-adminlte-button id="imprimir" title="Imprimir Resumen" class="mx-4" theme="info" icon="fas fa-print" ></x-adminlte-button>
            </div>
            <div class="col-lg-12 my-2">
                <p class="p-1 text-center bg-light"><i class="fas fa-info-circle"></i> A continuación, se muestran los datos completos de la cotización</p>
            </div>
        </div>

        <div class="container-fluid row">
            <div class="col-lg-2">
                <x-adminlte-input name="folio" id="folio" readonly="true" value="{{ $cotizacion->id }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-hashtag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-2">
                <x-adminlte-input name="fecha" id="fecha" readonly="true" value="{{ $cotizacion->created_at }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-3">
                <x-adminlte-input name="cliente" id="cliente" readonly="true" value="{{ $cotizacion->cliente->nombre }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-portrait"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            
            
            <div class="col-lg-3">
                <x-adminlte-input name="modelo" id="modelo" readonly="true" value="{{ $cotizacion->modelo->nombre }} {{ $cotizacion->modelo->numero }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-2">
                <x-adminlte-input name="total" id="total" readonly="true" value="$ {{ $cotizacion->precio }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>

        <div class="container-fluid row p-2">
            <p class="col-lg-12 m-1 p-1 bg-secondary text-center"><b>Numeraciones</b></p>
            @php
                $heads = [''];
            @endphp

            <x-adminlte-datatable id="contenedorNumeraciones" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizacion->modelo->numeraciones ) > 0 )
                    <tr colspan="{{ count( $cotizacion->modelo->numeraciones ) }}">
                        
                        @foreach( $cotizacion->modelo->numeraciones as $numeracion)
                            
                            <td class="bg-light border"><b>{{ $numeracion->numero }}</b></td>
                        
                        @endforeach
                    </tr>
                    <!--<tr>

                        @foreach( $cotizacion->modelo->numeraciones as $numeracion )
                            <td class="text-center border">{{ $numeracion->cantidad( $cotizacion->id, $numeracion->id) }}</td>
                        @endforeach

                    </tr>-->
                @else
                    <tr>
                        <td colspan="12" class="fw-semibold">No hay numeraciones registradas.</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        <div class="container-fluid row p-2">
            <p class="col-lg-12 m-1 p-1 bg-secondary text-center"><b>Desarrollo</b></p>
            
            <div class="col-lg-3">
                @php
                    $suela = implode(', ', $cotizacion->suelas->pluck('nombre')->toArray());
                @endphp
                <x-adminlte-input name="suela" id="suela" readonly="true" value="{{ $suela ? $suela : 'Sin suela' }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-6">
                @php
                    $colores = implode(', ', $cotizacion->colores()->pluck('colorMaterial')->filter()->toArray());
                    $colores = array_unique( explode( ', ', $colores) );
                    $colores = implode( ', ', $colores );

                    if( $colores === '' || $colores === NULL ){

                        $colores = 'Sin colores agregados';

                    }

                @endphp
                <x-adminlte-input name="colores" id="colores" readonly="true" value="{{ $colores }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-palette"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

            </div>
            <div class="col-lg-12">
                <x-adminlte-input name="observaciones" id="observaciones" readonly="true" value="{{ $cotizacion->observaciones ? $cotizacion->oservaciones : 'Sin observaciones' }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>

        <div class="container-fluid row p-1">
            @php
                $heads = ['Pieza', 'Material', 'Color', 'Cantidad', 'Alto x Largo', 'Costo'];
                $config = ['pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="contenedorPiezas" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizacion->piezas ) > 0 )
                    
                    @foreach( $cotizacion->piezas as $pieza)
                        <tr>
                            <td class="border"><b>{{ $pieza->nombre }}</b></td>
                            @php
                                $material = $pieza->materiales( $cotizacion->id )->first();
                            @endphp
                            <td class="border">{{ $material->nombre }}</td>
                            @php
                                $color = implode(', ', $pieza->color( $cotizacion->id )->pluck('colorMaterial')->toArray());
                            @endphp
                            <td class="border">{{ $color }}</td>
                            <td class="border">{{ $pieza->cantidad }}</td>
                            <td class="border">{{ $pieza->alto }} X {{ $pieza->largo }}</td>
                            <td class="border">$ {{ number_format( (($pieza->largo * $pieza->alto) * $pieza->cantidad) / ($material->unidades * 100)*$material->precio  ,2 ) }}</td>
                        </tr>     
                        
                    @endforeach

                @else
                    <tr>
                        <td colspan="12" class="fw-semibold">No hay piezas registradas.</td>
                    </tr>
                @endif

            </x-adminlte-datatable>
        </div>

        <div class="container-fluid row p-1">

            @php
                $heads = ['Tipo', 'Consumible', 'Precio'];
                $config = ['pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="contenedorConsumibles" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizacion->consumibles ) > 0 )
                    
                    @foreach( $cotizacion->consumibles as $consumible)
                        <tr>
                            <td class="border"><b>{{ $consumible->tipo }}</b></td>
                            <td class="border">{{ $consumible->nombre }}</td>
                            <td class="border">$ {{ $consumible->precio }}</td>
                        </tr>     
                        
                    @endforeach

                @else
                    <tr>
                        <td colspan="12" class="fw-semibold">No hay consumibles registrados.</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>

@stop