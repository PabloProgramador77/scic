<x-adminlte-modal id="modalEditar" title="Editar Actividad" theme="info" icon="fas fa-edit" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreActividadEditar" id="nombreActividadEditar" placeholder="Nombre de actividad">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-clipboard">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="ordenActividadEditar" id="ordenActividadEditar" placeholder="Orden de actividad">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-sort-numeric-down">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-select name="tipoEditar" id="tipoEditar" label-class="text-info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                    <option value="">Seleccione un tipo</option>
                    <option value="Normal">Normal</option>
                    <option value="Opcional">Opcional</option>
                </x-adminlte-select>
            </div>
            <div class="form-group">
                <x-adminlte-select name="usuarioEditar" id="usuarioEditar" label-class="text-info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                    <option value="">Seleccione un responsable</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </x-adminlte-select>
            </div>
            <div class="form-group">
                <x-adminlte-input name="duracionEditar" id="duracionEditar" placeholder="Días de duración" type="number">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-calendar">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-textarea name="descripcionActividadEditar" id="descripcionActividadEditar" placeholder="Descripción de actividad" label-text="text-info">
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
        <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>