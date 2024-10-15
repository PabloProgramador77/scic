<x-adminlte-modal id="modalEditar" title="Editar Suela" theme="info" icon="fas fa-edit" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="Nombre de suela" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-shoe-prints">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="precioEditar" id="precioEditar" placeholder="Precio de suela" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="proveedorEditar" id="proveedorEditar" placeholder="Poveedor de suela" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-user-tie">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-textarea name="descripcionEditar" id="descripcionEditar" label-class="text-info" placeholder="Descripción breve de la suela (OPCIONAL)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>