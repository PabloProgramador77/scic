@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row border-bottom">

            <div class="col-lg-4">
                <h1 class="fs-3 fw-semibold text-primary"><i class="fas fa-file-invoice-dollar"></i> Cálculo</h1>
            </div>
            <div class="col-lg-6 my-3 form-group row">
                <x-adminlte-select2 class="col-lg-12 mx-1" id="modelo" name="modelo" label-class="info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                    @foreach($modelos as $modelo)
                        <option value="{{ $modelo->id }}">{{ $modelo->nombre }}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-input class="col-lg-12 mx-1" name="total" id="total" placeholder="Total" value="0" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="col-lg-2 my-2">
                <x-adminlte-button class="mx-2" theme="warning" data-toggle="modal" data-target="#modalCostos" icon="fas fa-dollar-sign" label="Costos"></x-adminlte-button>
                <a href="{{ url('/home') }}" class="btn btn-info p-2 mx-1 rounded"><i class="fas fa-home"></i></a>
            </div>
        </div>

        <div class="container-fluid row p-2">
            @php
                $heads = ['', 'Pieza', 'Material', 'Largo y Alto', 'Piezas', 'Área', 'Cm2', 'Dm', 'Unidades', 'MtsxPar', 'Costo', 'Total']
            @endphp

            <x-adminlte-datatable id="contenedorPiezas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                @if( count( $modelos ) > 0 )
                    <tr>
                        <td colspan="12" class="fw-semibold">Elige el modelo, introduce la cantidad de pares y elije los materiales de cada pieza.</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="12" class="fw-semibold">No hay modelos registrados. Por favor, registralos en <a href="url('modelos')">este enlace.</a></td>
                    </tr>
                @endif

            </x-adminlte-datatable>

        </div>

    </section>

    @include('cotizacion.costos')

    <script src="{{ asset('js/jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/modelo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cotizacion/costos.js') }}" type="text/javascript"></script>

@stop