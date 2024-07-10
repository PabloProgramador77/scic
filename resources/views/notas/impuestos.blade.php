<x-adminlte-modal id="modalImpuesto" title="Costos Extra" theme="info" icon="fas fa-plus" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-info p-1 bg-light"><i class="fas fa-info-circle"></i> Activa y/o captura los datos solicitados para la nota actual. Si deseas agregar un monto de envio elige la opción "Envio cotizado" y captura el monto en el campo inferior.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input-switch name="iva" id="iva" data-off-text="Sin I.V.A." data-on-text="Con I.V.A.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary" >
                            <i class="fas fa-percentage"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-switch>
            </div>
            <div class="form-group">
                <x-adminlte-select2 name="envio" id="envio" label-class="info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary" >
                            <i class="fas fa-truck"></i>
                        </div>
                    </x-slot>
                    <option value="Sin envio">Sin envio</option>
                    <option value="Por cobrar">Por cobrar</option>
                    <option value="Envio cotizado">Envio cotizado</option>
                </x-adminlte-select2>
            </div>
            <div class="form-group">
                <x-adminlte-input name="monto" id="monto" disabled="true" placeholder="Monto del envío">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary" >
                            <i class="fas fa-coins"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Agregar" id="agregarImpuestos" icon="fas fa-plus-circle"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>