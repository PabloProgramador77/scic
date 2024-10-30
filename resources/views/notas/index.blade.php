@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-file"></i> Notas de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones"><i class="fas fa-portrait"></i> Clientes</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones/cliente/{{ $cliente->id }}"><i class="fas fa-file-invoice-dollar"></i> Cotizaciones de Cliente</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-file"></i> Notas de Cliente</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2">
                <a href="{{ url('/cotizador/cliente') }}/{{ $cliente->id }}" class="btn btn-primary rounded text-white" title="Cotizar"><i class="fas fa-plus-circle"></i> Cotizador</a>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Folio', 'Cliente', 'Total de Nota', 'Estado', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="notas" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $notas ) > 0 )
                    @foreach ($notas as $nota)

                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->cliente->nombre }}</td>
                            <td>$ {{ $nota->total }}</td>
                            <td><span class="p-1 rounded bg-teal">{{ $nota->estado }}</span></td>
                            <td>
                                @if( $nota->estado == 'Pendiente' )
                                    <a href="{{ url('/nota/editar') }}/{{ $nota->id }}/{{ $cliente->id }}" class="btn btn-info editar" title="Editar nota"><i class="fas fa-edit"></i></a>
                                    <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $nota->id }}" title="Borrar nota"></x-adminlte-button>
                                @else
                                    <x-adminlte-button class="consumos" theme="primary" icon="fas fa-square-root-alt" data-id="{{ $nota->id }}" title="Descargar Cálculo de Consumos"></x-adminlte-button>
                                @endif
                                <a href="{{ url('/nota/ver') }}/{{ $nota->id }}/{{ $cliente->id }}" class="btn btn-secondary" title="Ver nota"><i class="fas fa-info-circle"></i></a>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin notas registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/borrarCotizacion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/calculoConsumo.js') }}" type="text/javascript"></script>

@stop