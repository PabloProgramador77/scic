@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row">

            <div class="col-lg-12 p-2 m-1 row">

                <div class="col-lg-6 col-md-4 col-sm-6">
                    <x-adminlte-small-box title="Cotizaciones" text="Cotizaciones de modelos" icon="fas fa-file text-dark" theme="primary" url="{{ url('cotizaciones') }}" url-text="Ver datos"></x-adminlte-small-box>
                </div>
                
            </div>
            <!--<div class="col-lg-12 border-bottom">
                <h1 class="fs-2 fw-semibold text-primary">Agenda de Pedidos</h1>
            </div>
            
            <div class="col-lg-12 p-2 m-1 row shadow">
                <p class="bg-light fw-semibold text-center col-lg-12">A continuación, se muestra de forma general los datos de los pedidos y sus avances.</p>
                <div class="container-fluid">
                    @php
                        $heads = ['Cotización', 'Modelo', 'Proceso', 'Usuario', 'Progreso', 'Estatus', 'Fecha Límite', 'Observaciones'];
                        $config = ['order' => [[1, 'asc']], 'pageLength' => [25], 'lengthMenu' => [10, 25, 50, 75, 100]];
                    @endphp
                    <p class="p-1 fw-semibold text-primary"><i class="fas fa-file"></i> <b>Nota #84</b></p>
                    <x-adminlte-datatable id="cronogramas" :heads="$heads" :config="$config" theme="light" hoverable bordered compressed beautify>
                        
                        <tr>
                            <td>#125</td>
                            <td>V13 1300</td>
                            <td>Corte</td>
                            <td><i class="fas fa-user-circle"></i> PabloProgramador</td>
                            <td> <x-adminlte-progress theme="primary" value="70" animated with-label></x-adminlte-progress> </td>
                            <td>
                                <x-adminlte-select name="estatus" id="estatus" class="bg-primary">
                                    <option value="1" class="bg-primary">En proceso</option>
                                    <option value="2" class="bg-warning">En espera</option>
                                    <option value="3" class="bg-success">Finalizado</option>   
                                </x-adminlte-select>
                            </td>
                            <td>31 de Enero 2025</td>
                            <td><x-adminlte-button icon="fas fa-info-circle" data-toggle="modal" data-target="#modalObservaciones"></x-adminlte-button></td>
                        </tr>
                        <tr>
                            <td>#126</td>
                            <td>V13 1300</td>
                            <td>Corte</td>
                            <td><i class="fas fa-user-circle"></i> PabloProgramador</td>
                            <td> <x-adminlte-progress theme="warning" value="30" animated with-label></x-adminlte-progress> </td>
                            <td>
                                <x-adminlte-select name="estatus" id="estatus" class="bg-warning">
                                    <option value="1" class="bg-primary">En proceso</option>
                                    <option value="2" class="bg-warning">En espera</option>
                                    <option value="3" class="bg-success">Finalizado</option>   
                                </x-adminlte-select>
                            </td>
                            <td>31 de Enero 2025</td>
                            <td><x-adminlte-button icon="fas fa-info-circle" data-toggle="modal" data-target="#modalObservaciones"></x-adminlte-button></td>
                        </tr>
                        <tr>
                            <td>#127</td>
                            <td>V13 1300</td>
                            <td>Finalizado</td>
                            <td><i class="fas fa-user-circle"></i> PabloProgramador</td>
                            <td> <x-adminlte-progress theme="success" value="100" animated with-label></x-adminlte-progress> </td>
                            <td>
                                <x-adminlte-select name="estatus" id="estatus" class="bg-success">
                                    <option value="1" class="bg-primary">En proceso</option>
                                    <option value="2" class="bg-warning">En espera</option>
                                    <option value="3" class="bg-success">Finalizado</option>   
                                </x-adminlte-select>
                            </td>
                            <td>31 de Enero 2025</td>
                            <td><x-adminlte-button icon="fas fa-info-circle" data-toggle="modal" data-target="#modalObservaciones"></x-adminlte-button></td>
                        </tr>
                        <tr>
                            <td>#128</td>
                            <td>V13 1300</td>
                            <td>Corte</td>
                            <td><i class="fas fa-user-circle"></i> PabloProgramador</td>
                            <td> <x-adminlte-progress theme="danger" value="10" animated with-label></x-adminlte-progress> </td>
                            <td>
                                <x-adminlte-select name="estatus" id="estatus" class="bg-danger">
                                    <option value="1" class="bg-primary">En proceso</option>
                                    <option value="2" class="bg-warning">En espera</option>
                                    <option value="3" class="bg-success">Finalizado</option>   
                                </x-adminlte-select>
                            </td>
                            <td>31 de Enero 2025</td>
                            <td><x-adminlte-button icon="fas fa-info-circle" data-toggle="modal" data-target="#modalObservaciones"></x-adminlte-button></td>
                        </tr>

                    </x-adminlte-datatable>
                </div>
            </div>-->
            
        </div>

        @include('observaciones')

    </section>

@stop