@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-box"></i> Consumibles</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/modelos"><i class="fas fa-socks"></i> Modelos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-box"></i> Consumibles</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo consumible" label="Consumible"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Nombre', 'Tipo', 'Total', 'Descripción', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [100], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="consumibles" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $consumibles ) > 0 )
                    
                    @foreach ($consumibles as $consumible)

                        <tr>
                            <td>{{ $consumible->nombre }}</td>
                            <td>{{ $consumible->tipo }}</td>
                            <td>$ {{ $consumible->precio }}</td>

                            @if( $consumible->descripcion == NULL )
                                <td>Descripción desconocida</td>
                            @else
                                <td>{{ $consumible->descripcion }}</td>
                            @endif
                            
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $consumible->id }}" title="Editar consumible"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $consumible->id }}" title="Borrar consumible"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach

                @else
                    
                    <tr>
                        <td colspan="5" class="text-info">Sin consumibles registrados</td>
                    </tr>

                @endif

            </x-adminlte-datatable>

        </div>

        @include('consumibles.nuevo')
        @include('consumibles.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/consumibles/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/consumibles/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/consumibles/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/consumibles/borrar.js') }}" type="text/javascript"></script>

@stop