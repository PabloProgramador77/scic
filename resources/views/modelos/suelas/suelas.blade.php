<x-adminlte-modal id="modalSuela" title="Suelas para Modelo" size="xl" theme="info" icon="fas fa-shoe-prints" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary bg-light p-1 rounded text-center"><b><i class="fas fa-info-circle"></i> Elige la(s) suela(s) que deseas agregar el modelo actual</b></p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreModeloSuela" id="nombreModeloSuela" readonly="true" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group container-fluid">
                @php
                    $heads = [ '', 'Suela', 'Precio', 'Descripción' ];
                @endphp
                <x-adminlte-datatable id="contenedorSuelas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModeloSuela" id="idModeloSuela" value="{{ $modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregarSuela" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>