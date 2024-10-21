<x-adminlte-modal id="modalPreeliminar" title="Cotización de Modelo" size="xl" theme="warning" icon="fas fa-file-invoice" static-backdrop scrollable>

    <div class="container-fluid row">
        <div class="col-lg-5">
            <x-adminlte-input name="clientePreeliminar" id="clientePreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-portrait"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        <div class="col-lg-5">
            <x-adminlte-input name="modeloPreeliminar" id="modeloPreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-shoe-prints"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        <div class="col-lg-2">
            <x-adminlte-input name="totalPreeliminar" id="totalPreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
    </div>

    <div class="container-fluid row p-2">
        <p class="col-lg-12 m-1 p-1 bg-secondary text-center"><b>Desarrollo</b></p>
        
        <div class="col-lg-3">
            <x-adminlte-input name="suelaPreeliminar" id="suelaPreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-shoe-prints">Suela</i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        <div class="col-lg-3">
            <x-adminlte-input name="hormaPreeliminar" id="hormaPreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-shoe-prints">Horma</i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        <div class="col-lg-6">
            <x-adminlte-input name="coloresPreeliminar" id="coloresPreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-palette">Colores</i>
                    </div>
                </x-slot>
            </x-adminlte-input>

        </div>
        <div class="col-lg-12">
            <x-adminlte-input name="observacionesPreeliminar" id="observacionesPreeliminar" readonly="true" value="">
                <x-slot name="prependSlot">
                    <div class="input-group-text text-success">
                        <i class="fas fa-edit">Observaciones</i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
    </div>

    <div class="container-fluid row p-1">
        @php
            $heads = ['Pieza', 'Material', 'Color', 'Cantidad', 'Alto x Largo', 'Costo'];
        @endphp
        <x-adminlte-datatable id="PreeliminarPiezas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

        </x-adminlte-datatable>
    </div>

    <div class="container-fluid row p-1">
        @php
            $heads = ['Tipo', 'Insumo / Consumible', 'Importe'];
        @endphp
        <x-adminlte-datatable id="PreeliminarConsumibles" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

        </x-adminlte-datatable>

    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Terminar" id="agregarSuela" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Regresar" id="cancelarSuela" data-dismiss="modal" icon="fas fa-undo-alt"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>