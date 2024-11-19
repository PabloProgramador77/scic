<x-adminlte-modal id="modalNuevoSuela" title="Nueva Suela" theme="primary" icon="fas fa-plus" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreSuela" id="nombreSuela" placeholder="Nombre de suela" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="precioSuela" id="precioSuela" placeholder="Precio de suela" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="proveedorSuela" id="proveedorSuela" placeholder="Proveedor de suela" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-user-tie">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-textarea name="descripcionSuela" id="descripcionSuela" label-class="text-info" placeholder="Descripción breve de la suela">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>
            
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Registrar" id="registrarSuela" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelarSuela" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>