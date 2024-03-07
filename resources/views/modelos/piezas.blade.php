@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-6">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-socks"></i> Piezas de Modelos</h1>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-lg-4 my-2">
                <x-adminlte-input name="nombreModelo" id="nombreModelo" readonly="true" value="{{ $modelo->nombre }} - {{ $modelo->numero }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-2 my-2">
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
            </div>
        </div>

        <div class="container-fluid row p-2">
            <p class="bg-light fs-6 fw-semibold text-info d-block p-2 col-lg-12">A continuación, elige las piezas para el modelo e introduce la cantidad de estas:</p>            
                
                @if ( count( $piezas ) > 0 )
                    @foreach($piezas as $pieza)

                    <!--<div class="form-check m-1">
                        <input class="form-check-input pieza" type="checkbox" value="{{ $pieza->nombre }}" id="pieza{{ $pieza->id }}" data-id="{{ $pieza->id }}" data-toggle="modal" data-target="#modalPiezas">
                        <label class="form-check-label" for="pieza{{ $pieza->id }}">{{ $pieza->nombre }}</label>
                    </div>-->
                    <div class="custom-control custom-switch col-lg-2 col-md-4 col-sm-6" style="float: left; margin-bottom: 15px;">
                        <input type="checkbox" class="custom-control-input pieza" name="nota" id="{{ $pieza->id }}" value="{{ $pieza->nombre }}" data-id="{{ $pieza->id }}" data-toggle="modal" data-target="#modalPiezas">
                        <label class="custom-control-label" for="{{ $pieza->id }}">{{ $pieza->nombre }}    
                    </div>
                        

                    @endforeach

                @else
                    
                    <div class="col-12">
                        <p class="fw-semibold fs-5 text-center">Sin piezas registradas. <a href="{{ url('/piezas') }}">Agregar piezas ahora</a></p>
                    </div>

                @endif

        </div>

        @include('modelos.cantidad')

    </section>

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modelos/piezas.js') }}" type="text/javascript"></script>

@stop