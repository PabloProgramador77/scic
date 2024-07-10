<x-adminlte-modal id="modalConsumible" title="Consumibles de Modelo" size="xl" theme="secondary" icon="fas fa-socks" static-backdrop scrollable>
    <div class="container-fluid row border-bottom">
        <div class="row col-lg-12 col-md-12 col-sm-12 p-1 m-1">
            <p class="text-info bg-light p-2 rounded text-center col-lg-10 col-md-8 col-sm-12 m-1"><b><i class="fas fa-info-circle"></i> Elige los consumibles que deseas agregar el modelo actual o si es necesario agrega uno nuevo presionando el botón "+ Consumible"</b></p>
            <x-adminlte-button id="nuevoConsumible" theme="primary" icon="fas fa-plus-circle" label=" Consumible" data-toggle="modal" data-target="#modalNuevoConsumible" class="m-1"></x-adminlte-button>
        </div>
        <form novalidate class="container-fluid row">
            <div class="form-group">
                <x-adminlte-input name="nombreModeloConsumible" id="nombreModeloConsumible" readonly="true" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group container-fluid">
                @php
                    $heads = [ '', 'Consumible', 'Tipo', 'Total' ];
                @endphp
                <x-adminlte-datatable id="contenedorConsumibles" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModelo" id="idModelo" value="{{ $modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregarConsumible" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>