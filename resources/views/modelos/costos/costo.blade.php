<x-adminlte-modal id="modalCosto" title="Costos Base" size="xl" theme="secondary" icon="fas fa-socks" static-backdrop scrollable>
    <div class="container-fluid border-bottom row">
        <div class="row col-lg-12 col-md-12 col-sm-12 p-1 m-1">
            <p class="text-info bg-light p-2 rounded text-center col-lg-10 col-md-8 col-sm-12 m-1"><b><i class="fas fa-info-circle"></i> Elige los costos que deseas agregar el modelo actual o si es necesario agrega uno nuevo presionando el botón "+ Costo"</b></p>
            <x-adminlte-button id="nuevoCosto" theme="primary" icon="fas fa-plus-circle" label=" Costo Base" data-toggle="modal" data-target="#modalNuevoCosto" class="m-1"></x-adminlte-button>
        </div>
        <form novalidate class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <x-adminlte-input name="nombreModeloCosto" id="nombreModeloCosto" readonly="true" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints">Modelo: </i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="row col-lg-12 col-md-12 col-sm-12">
                @php
                    $heads = [ '', 'Costo', 'Descripción', 'Total' ];
                @endphp
                <x-adminlte-datatable id="contenedorCostos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModelo" id="idModelo" value="{{ $modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregarCosto" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>