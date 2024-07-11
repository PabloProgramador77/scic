@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-people-carry"></i> Proveedores de materiales</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-5 rounded" title="Inicio"><i class="fas fa-home"></i></a>
                <a href="{{ url('/materiales') }}" class="btn btn-secondary p-2 fw-semibold rounded" title="Materiales"><i class="fas fa-boxes"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo proveedor"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Proveedor', 'Teléfono', 'Dirección'];
            @endphp

            <x-adminlte-datatable id="proveedores" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $proveedores ) > 0 )
                    @foreach ($proveedores as $proveedor)

                        <tr>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $proveedor->id }}" title="Editar proveedor"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $proveedor->id }}" title="Borrar proveedor"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-info">Sin proveedores registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('materiales.proveedores.nuevo')
        @include('materiales.proveedores.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/proveedores/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/proveedores/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/proveedores/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/proveedores/borrar.js') }}" type="text/javascript"></script>

@stop