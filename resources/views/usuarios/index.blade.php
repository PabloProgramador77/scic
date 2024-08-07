@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-5 fw-semibold"><i class="fas fa-users"></i> Usuarios</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/home') }}" class="btn btn-warning p-2 mx-5 rounded" title="Inicio"><i class="fas fa-home"></i></a>
                <a href="{{ url('/roles') }}" class="btn btn-secondary p-2 fw-semibold rounded" title="Roles de Usuario"><i class="fas fa-user-tag" ></i></a>
                <a href="{{ url('/permisos') }}" class="btn btn-secondary p-2 fw-semibold rounded" title="Permisos de Usuario"><i class="fas fa-user-cog"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo Usuario"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Usuario', 'Email', 'Acciones'];
            @endphp

            <x-adminlte-datatable id="usuarios" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $usuarios ) > 0 )
                    @foreach ($usuarios as $usuario)

                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $usuario->id }}" title="Editar usuario"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $usuario->id }}" title="Borrar usuario"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-info"><i class="fas fa-info-circle"></i> Sin usuarios registrados</td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

        @include('usuarios.nuevo')
        @include('usuarios.editar')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuarios/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuarios/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuarios/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuarios/borrar.js') }}" type="text/javascript"></script>

@stop