<x-adminlte-modal id="modalPiezas" title="Cantidad de Piezas" size="md" theme="secondary" icon="fas fa-socks" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>¿Cuantas piezas de estas lleva el modelo?</b></p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreModelo" id="nombreModelo" readonly="true" value="{{ $modelo->nombre }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="nombrePieza" id="nombrePieza" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-socks"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="cantidad" id="cantidad" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idModelo" id="idModelo" value="{{ $modelo->id }}">
            <input type="hidden" name="idPieza" id="idPieza">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>