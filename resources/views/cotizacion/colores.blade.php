<x-adminlte-modal id="modalColores" title="Colores de suela" theme="warning" icon="fas fa-palette" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Edita los colores de la suela como crear necesario.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="suelaEditar" id="suelaEditar" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="colorPisoEditar" id="colorPisoEditar" placeholder="Color de piso">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-palette"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="colorCunaEditar" id="colorCunaEditar" placeholder="Color de cuña">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-palette"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idCotizacionColores" id="idCotizacionColores">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" id="colorear" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>