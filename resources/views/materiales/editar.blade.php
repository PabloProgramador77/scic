<x-adminlte-modal id="modalEditar" title="Editar Material" theme="info" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="Nombre de material">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="conceptoEditar" id="conceptoEditar" placeholder="Concepto de material">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="precioEditar" id="precioEditar" placeholder="Precio de material">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select2 id="proveedorEditar" name="proveedorEditar" label-class="info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <img src="{{ asset('media/icons/proveedor.png') }}" alt="Icono Cargo" width="20px" height="auto">*
                        </div>
                    </x-slot>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>