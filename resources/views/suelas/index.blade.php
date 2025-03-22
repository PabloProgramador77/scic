@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-shoe-prints"></i> Suelas</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/modelos"><i class="fas fa-socks"></i> Modelos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-shoe-prints"></i> Suelas</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nueva suela" label="Suela" class="shadow"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Suela', 'Precio', 'Proveedor', 'Descripción', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [50], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="suelas" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $suelas ) > 0 )
                    @foreach ($suelas as $suela)

                        <tr>
                            <td>{{ $suela->nombre }}</td>
                            <td>$ {{ $suela->precio }}</td>
                            <td>{{ ($suela->proveedor ? : 'Proveedor desconocido') }}</td>
                            <td>{{ ($suela->descripcion ? : 'Sin descripción') }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $suela->id }}" title="Editar suela"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $suela->id }}" title="Borrar suela"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin suelas registradas</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('suelas.nuevo')
        @include('suelas.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suelas/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suelas/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suelas/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/suelas/borrar.js') }}" type="text/javascript"></script>

@stop