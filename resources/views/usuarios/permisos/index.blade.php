@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary">Permisos de usuarios</h1>
                <p class="fs-6 fw-semibold text-secondary">Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/usuarios') }}" class="btn btn-secondary p-2 fw-semibold rounded mx-1">Usuarios <i class="fas fa-user"></i></a>
                <a href="{{ url('/roles') }}" class="btn btn-dark p-2 fw-semibold rounded mx-1">Roles de usuario <i class="fas fa-user-tag"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Permiso de usuario', 'Guard', 'Acciones']
            @endphp

            <x-adminlte-datatable id="permisos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $permisos ) > 0 )
                    @foreach ($permisos as $permiso)

                        <tr>
                            <td>{{ $permiso->name }}</td>
                            <td>{{ $permiso->guard }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $permiso->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $permiso->id }}"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-info">Sin permisos registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('usuarios.permisos.nuevo')
        @include('usuarios.permisos.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permisos/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permisos/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permisos/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permisos/borrar.js') }}" type="text/javascript"></script>

@stop