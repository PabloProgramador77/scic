@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">
            
            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-file"></i> Cotizaciones de {{ $cliente->nombre }}</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
                <input type="hidden" name="idCliente" id="idCliente" value="{{ $cliente->id }}">
            </div>
            <div class="col-lg-4 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/cotizaciones"><i class="fas fa-portrait"></i> Clientes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cotizaciones de Cliente</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-3 my-2">
                <a href="{{ url('/cotizador/cliente') }}/{{ $cliente->id }}" class="btn btn-primary p-2 mx-1 rounded" title="Nueva cotización"><i class="fas fa-plus-circle"></i> <b>Cotizador</b></a>
                <x-adminlte-button class="p-2" id="nota" theme="primary" label=" Nota" icon="fas fa-plus-circle" title="Nueva nota"></x-adminlte-button>
                <x-adminlte-button class="p-2" id="copiar" theme="secondary" icon="fas fa-paste" title="Copiar cotizaciones" data-toggle="modal" data-target="#modalClientes" data-id="{{ $cliente->id }}"></x-adminlte-button>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 fw-semibold text-center bg-warning p-1 rounded">
                    <i class="fas fa-info-circle"></i>Elige una cotización para gestionar. De lo contrario pulsa el botón "<i class="fas fa-plus-circle"></i>Cotización" para registrar una nueva.<i class="fas fa-info-cirlce"></i>
                </p>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['[ ]', 'Folio', 'Descripción', 'Color', 'Modelo', 'Precio Unitario', 'Observaciones',  'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [50], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="cotizaciones" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $cotizaciones ) > 0 )
                    @foreach ($cotizaciones as $cotizacion)

                        <tr>
                            <td>
                                <input type="checkbox" name="cotizacion" id="cotizacion" class="custom-checkbox" data-id="{{ $cotizacion->id }}">
                            </td>
                            <td>{{ $cotizacion->id }}</td>
                            <td>{{ $cotizacion->descripcion ? : 'Sin descripción' }}</td>
                            <td>{{ ( $cotizacion->color ? : 'Sin color' ) }}</td>
                            <td>{{ $cotizacion->modelo->nombre }} - {{ $cotizacion->modelo->numero }}</td>
                            <td>$ {{ $cotizacion->precio }}</td>
                            <td>{{ $cotizacion->observaciones }}</td>
                            <td>
                                <a href="{{ url('cotizacion/editar') }}/{{ $cotizacion->id }}" class="btn btn-primary editar" title="Editar cotización"><i class="fas fa-edit"></i></a>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $cotizacion->id }}" data-value="{{ $cotizacion->folio }}" title="Borrar cotización"></x-adminlte-button>
                                <x-adminlte-button class="agregar" icon="fas fa-plus" theme="info" data-id="{{ $cotizacion->id }}" title="Agregar a nota previa" data-toggle="modal" data-target="#modalNotas"></x-adminlte-button>
                                <a href="{{ url('/cotizacion/ver') }}/{{ $cotizacion->id }}" class="btn btn-secondary rounded" role="button" title="Resumen de Cotización"><i class="fas fa-info-circle"></i></a>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-danger">Sin cotizaciones registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('cotizacion.notas')
        @include('cotizacion.clientes')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/nuevo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/cotizacion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/notas/agregarCotizacion.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/copiar.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(document).ready(function(){
            $('.editar').on('click', function() {
                Swal.fire({
                    title: 'Cargando...',
                    html: 'Espere un momento por favor',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timer: 25000,
                    timerProgressBar: true,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            });
        });
    </script>

@stop