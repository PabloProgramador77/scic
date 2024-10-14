@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-5">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-boxes"></i> Materiales</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/modelos"><i class="fas fa-socks"></i> Modelos</a></li>
                        <li class="breadcrumb-item"><a href="/proveedores"><i class="fas fa-people-carry"></i> Proveedores</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-boxes"></i> Materiales</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo material" label=" Material"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Tipo', 'Proveedor', 'Material', 'Color', 'Precio', 'Ancho de Material', 'Acciones'];
                $config = [ 'order' => [[1, 'asc']], 'pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="materiales" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $materiales ) > 0 )
                    @foreach ($materiales as $material)

                        <tr>
                            <td>{{ $material->concepto }}</td>
                            <td>
                                @foreach($material->proveedores as $proveedor)
                                    {{ $proveedor->nombre }}
                                @endforeach
                            </td>
                            <td>{{ $material->nombre }}</td>
                            @if( $material->color == '' || $material->color == NULL )
                                <td>Sin color</td>
                            @else
                                <td>{{ $material->color }}<input type="color" class="form-control form-control-color" value="{{ $material->hexColor }}" readonly="true" disabled="true"></td>
                            @endif
                            
                            <td>$ {{ $material->precio }}</td>
                            <td>{{ $material->unidades }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $material->id }}" title="Editar material"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $material->id }}" title="Borrar material"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-info">Sin materiales registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('materiales.nuevo')
        @include('materiales.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/materiales/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/materiales/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/materiales/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/materiales/borrar.js') }}" type="text/javascript"></script>

@stop