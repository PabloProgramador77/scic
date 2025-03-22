@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-4">
                <h1 class="fs-5 fw-semibold"><i class="fas fa-users"></i> Usuarios</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-tie"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-6 my-2">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/roles"><i class="fas fa-user-tag"></i> Roles de Usuario</a></li>
                        <li class="breadcrumb-item"><a href="/permisos"><i class="fas fa-user-cog"></i> Permisos de Usuario</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-users"></i> Usuarios</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus" title="Nuevo Usuario" label="Usuario" class="shadow"></x-adminlte-button>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['Usuario', 'Email', 'Acciones'];
                $config = ['order' => [[1, 'asc']], 'pageLength' => [50], 'lengthMenu' => [10, 25, 50, 75, 100]];
            @endphp

            <x-adminlte-datatable id="usuarios" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

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