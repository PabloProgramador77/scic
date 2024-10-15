<x-adminlte-modal id="modalEditar" title="Editar Cliente" theme="secondary" icon="fas fa-edit" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Edita los datos como necesites. Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="numeroEditar" id="numeroEditar" placeholder="N° de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-hashtag">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="Nombre de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-user">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="telefonoEditar" id="telefonoEditar" placeholder="Telefono de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-phone">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="emailEditar" id="emailEditar" placeholder="Email de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="estadoEditar" id="estadoEditar" placeholder="Estado de residencia de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="ciudadEditar" id="ciudadEditar" placeholder="Ciudad de residencia de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="empresaEditar" id="empresaEditar" placeholder="Empresa de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-building"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="razonEditar" id="razonEditar" placeholder="Razón social de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-id-card-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="rfcEditar" id="rfcEditar" placeholder="RFC de cliente">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idCliente" id="idCliente">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Guardar cambios" id="actualizar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>