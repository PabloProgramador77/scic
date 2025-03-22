@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-clipboard"></i> Actividades</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-clipboard"></i> Actividades</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo actividad"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Orden', 'Actividad', 'Usuario responsable', 'Proceso', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [50], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="actividades" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $actividades ) > 0 )
                    @foreach ($actividades as $actividad)

                        <tr>
                            <td>{{ $actividad->orden }}</td>
                            <td>{{ $actividad->nombre }}</td>
                            <td>{{ $actividad->usuario->name }}</td>
                            <td>{{ $actividad->proceso->nombre }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $actividad->id }}" data-value="{{ $actividad->id }}, {{ $actividad->nombre }}, {{ $actividad->descripcion }}, {{ $actividad->orden }}, {{ $actividad->duracion }}, {{ $actividad->idProceso }}, {{ $actividad->idUsuario }}, {{ $actividad->usuario->name }}, {{ $actividad->tipo }}" title="Editar actividad"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $actividad->id }}" data-value="{{ $actividad->nombre }}" title="Borrar actividad"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger">Sin actividades registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('actividades.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/actividades/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/actividades/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/actividades/borrar.js') }}" type="text/javascript"></script>

@stop