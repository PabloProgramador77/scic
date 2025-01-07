<x-adminlte-modal id="modalActividad" title="Nueva Actividad" theme="primary" icon="fas fa-plus" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreActividad" id="nombreActividad" placeholder="Nombre de actividad">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-clipboard">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="ordenActividad" id="ordenActividad" placeholder="Orden de actividad">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-sort-numeric-down">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-select name="tipo" id="tipo" label-class="text-info">
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
                <x-adminlte-select name="usuario" id="usuario" label-class="text-info">
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
                <x-adminlte-input name="duracion" id="duracion" placeholder="Días de duración" type="number">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-calendar">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-textarea name="descripcionActividad" id="descripcionActividad" placeholder="Descripción de actividad" label-text="text-info">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>
            <input type="hidden" name="idProceso" id="idProceso">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Registrar" id="agregar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>