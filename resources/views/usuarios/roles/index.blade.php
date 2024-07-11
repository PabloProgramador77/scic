@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold"><i class="fas fa-user-tag"></i> Roles de usuarios</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-5 rounded" title="Inicio"><i class="fas fa-home"></i></a>
                <a href="{{ url('/usuarios') }}" class="btn btn-secondary p-2 fw-semibold rounded" title="Usuarios"><i class="fas fa-users"></i></a>
                <a href="{{ url('/permisos') }}" class="btn btn-secondary p-2 fw-semibold rounded" title="Permisos de Usuarios"><i class="fas fa-user-cog"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo Rol de Usuario"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Rol de usuario', 'Guard', 'Acciones']
            @endphp

            <x-adminlte-datatable id="roles" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $roles ) > 0 )
                    @foreach ($roles as $role)

                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->guard }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $role->id }}" title="Editar rol de usuario"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $role->id }}" title="Borrar rol de usuario"></x-adminlte-button>
                                <x-adminlte-button class="permisos" icon="fas fa-user-cog" theme="secondary" data-id="{{ $role->id }}" data-toggle="modal" data-target="#modalPermisos" title="Asignar permisos a rol"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-info">Sin roles registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('usuarios.roles.nuevo')
        @include('usuarios.roles.editar')
        @include('usuarios.roles.permisos')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/roles/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/roles/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/roles/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/roles/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/roles/permisos.js') }}" type="text/javascript"></script>

@stop