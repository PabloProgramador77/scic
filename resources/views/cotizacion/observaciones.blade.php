<x-adminlte-modal id="modalObservaciones" title="Observaciones de cotización" theme="light" icon="fas fa-comment-alt" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="observacionesEditar" id="observacionesEditar" placeholder="Observaciones de cotización">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idCotizacionObservaciones" id="idCotizacionObservaciones">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" id="observar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>