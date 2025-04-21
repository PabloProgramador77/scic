@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-socks"></i> Modelos</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-socks"></i> Modelos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo modelo" label=" Modelo"></x-adminlte-button>
                <x-adminlte-button theme="info" data-toggle="modal" data-target="#modalGanancia" icon="fas fa-hand-holding-usd" title="Ganancia" id="modeloGanancia"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'N°', 'Descripción', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [100], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="modelos" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $modelos ) > 0 )
                    @foreach ($modelos as $modelo)

                        <tr>
                            <td>{{ $modelo->nombre }}</td>
                            <td>{{ $modelo->numero }}</td>
                            <td>
                                @if( $modelo->descripcion == NULL )
                                    Descripción desconocida
                                @else
                                    {{ $modelo->descripcion }}
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $modelo->id }}" title="Editar modelo"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $modelo->id }}" title="Borrar modelo"></x-adminlte-button>
                                <a href="{{ url('modelo/piezas') }}/{{ $modelo->id }}" class="btn btn-secondary rounded" theme="secondary" title="Configurar modelo"><i class="fas fa-cog"></i></a>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin modelos registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('modelos.nuevo')
        @include('modelos.editar')
        @include('modelos.ganancia')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/ganancia.js') }}" type="text/javascript"></script>

@stop