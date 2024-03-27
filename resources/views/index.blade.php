@extends('home')
@section('contenido')

    <section class="container-fluid p-2 bg-white">

        <div class="container-fluid row">

            <div class="col-lg-12 p-2 m-1">

                <div class="col-lg-4 col-md-3 col-sm-6">
                    <x-adminlte-small-box title="Cotizaciones" text="Cotizaciones de modelos" icon="fas fa-file-invoice-dollar text-dark" theme="primary" url="{{ url('cotizacion') }}" url-text="Nueva Cotización"></x-adminlte-small-box>
                </div>
                
            </div>
            <div class="col-lg-12 border-bottom">
                <h1 class="fs-2 fw-semibold text-primary">Resumen Empresarial</h1>
            </div>
            
            <div class="col-lg-12 p-2 m-1 border row shadow">
                <p class="bg-light fw-semibold text-center col-lg-12">Información rápida del sistema</p>
                <div class="col-lg-3">
                    <x-adminlte-small-box title="0" text="Usuario registrados" icon="fas fa-users" theme="info"></x-adminlte-small-box>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-small-box title="0" text="Modelos registrados" icon="fas fa-shoe-prints" theme="primary"></x-adminlte-small-box>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-small-box title="0" text="Piezas registradas" icon="fas fa-socks" theme="secondary"></x-adminlte-small-box>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-small-box title="0" text="Materiales registrados" icon="fas fa-boxes" theme="teal"></x-adminlte-small-box>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-small-box title="0" text="Costos registrados" icon="fas fa-file-invoice-dollar" theme="warning"></x-adminlte-small-box>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-small-box title="0" text="Proveedores registrados" icon="fas fa-people-carry" theme="purple"></x-adminlte-small-box>
                </div>
            </div>
            

        </div>

    </section>

@stop