@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary">Usuarios</h1>
                <p class="fs-6 fw-semibold text-secondary">Panel de Administrador</p>
            </div>
            <div class="col-lg-5 my-2">
                <a href="{{ url('/roles') }}" class="btn btn-secondary p-2 fw-semibold rounded mx-1">Roles de Usuarios <i class="fas fa-user-tag"></i></a>
                <a href="{{ url('/permisos') }}" class="btn btn-dark p-2 fw-semibold rounded mx-1">Permisos de Usuarios <i class="fas fa-user-cog"></i></a>
            </div>
            <div class="col-lg-1 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus"></x-adminlte-button>
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
                                <x-adminlte-button class="editar" icon="fas fa-edit" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $usuario->id }}"></x-adminlte-button>
                                <x-adminlte-button class="borrar" icon="fas fa-trash" theme="danger" data-id="{{ $usuario->id }}"></x-adminlte-button>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-info">Sin usuarios registrados</td>
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