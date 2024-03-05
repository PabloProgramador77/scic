@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-boxes"></i> Materiales</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/proveedores') }}" class="btn btn-secondary p-2 fw-semibold rounded mx-1">Proveedores <i class="fas fa-people-carry"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Concepto', 'Proveedor', 'Material', 'Precio', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="materiales" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

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
                            <td>$ {{ $material->precio }} MXN</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $material->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $material->id }}"></x-adminlte-button>
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