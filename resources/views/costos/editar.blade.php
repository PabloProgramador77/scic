<x-adminlte-modal id="modalEditar" title="Editar Costo" theme="info" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="Nombre de costo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-user">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-select2 id="tipoEditar" name="tipoEditar" label-class="info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <img src="{{ asset('media/icons/proveedor.png') }}" alt="Icono Cargo" width="20px" height="auto">*
                        </div>
                    </x-slot>
                    <option value="Base">Costo Base</option>
                    <option value="Neutro">Costo Neutro</option>
                </x-adminlte-select2>
            </div>
            <div class="form-group">
                <x-adminlte-input name="totalEditar" id="totalEditar" placeholder="Total">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-money-bill">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-textarea name="descripcionEditar" id="descripcionEditar" placeholder="Descripción de costo" label-text="text-info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>