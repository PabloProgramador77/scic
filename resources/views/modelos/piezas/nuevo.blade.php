<x-adminlte-modal id="modalPieza" title="Nueva Pieza" theme="primary" icon="fas fa-plus" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de pieza">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-socks">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="alto" id="alto" placeholder="Alto de pieza">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-ruler-vertical">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="largo" id="largo" placeholder="Largo de pieza">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-ruler-horizontal">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="cantidad" id="cantidad" placeholder="Cantidad de piezas">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-tag">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-input name="suaje" id="suaje" placeholder="Suaje de pieza">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group">
                <x-adminlte-textarea name="descripcion" id="descripcion" placeholder="Descripción de pieza" label-text="text-secondary">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Registrar" id="registrar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>