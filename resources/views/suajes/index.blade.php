@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-socks"></i> Suajes</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-shoe-prints"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-socks"></i> Suajes</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo suaje" label=" Suaje"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'N°', 'Descripción', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [50], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="suajes" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $suajes ) > 0 )
                    @foreach ($suajes as $suaje)

                        <tr>
                            <td>{{ $suaje->nombre }}</td>
                            <td>{{ $suaje->numero }}</td>
                            <td>
                                @if( $suaje->descripcion == NULL )
                                    Descripción desconocida
                                @else
                                    {{ $suaje->descripcion }}
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $suaje->id }}" data-value="{{ $suaje->id }}, {{ $suaje->nombre }}, {{ $suaje->numero }}, {{ $suaje->descripcion }}" title="Editar suaje"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $suaje->id }}" data-value="{{ $suaje->nombre }}" title="Borrar suaje"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger">Sin suajes registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('suajes.nuevo')
        @include('suajes.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suajes/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suajes/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suajes/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suajes/borrar.js') }}" type="text/javascript"></script>

@stop