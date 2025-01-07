@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-clipboard"></i> Procesos</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-clipboard"></i> Procesos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo proceso"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['N°', 'Proceso', 'Descripción', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="procesos" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $procesos ) > 0 )
                    @foreach ($procesos as $proceso)

                        <tr>
                            <td>{{ $proceso->id }}</td>
                            <td>{{ $proceso->nombre }}</td>
                            <td>
                                @if( $proceso->descripcion == NULL )
                                    Descripción desconocida
                                @else
                                    {{ $proceso->descripcion }}
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $proceso->id }}" data-value="{{ $proceso->id }}, {{ $proceso->nombre }}, {{ $proceso->descripcion }}, {{ $proceso->orden }}" title="Editar proceso"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $proceso->id }}" data-value="{{ $proceso->nombre }}" title="Borrar proceso"></x-adminlte-button>
                                <x-adminlte-button class="actividades" icon="fas fa-tags" theme="secondary" data-toggle="modal" data-target="#modalActividad" data-id="{{ $proceso->id }}" data-value="{{ $proceso->nombre }}" title="Agregar actividad"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger">Sin procesos registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('procesos.nuevo')
        @include('procesos.editar')
        @include('procesos.actividad')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/procesos/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/procesos/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/procesos/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/procesos/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/actividades/agregar.js') }}" type="text/javascript"></script>

@stop