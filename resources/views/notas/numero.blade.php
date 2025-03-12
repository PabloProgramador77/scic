<x-adminlte-modal id="modalNumero" title="N° de Nota" theme="secondary" icon="fas fa-file" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">A continuación, captura el número de nota</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="numeroNota" id="numeroNota" placeholder="Número de nota">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-hashtag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" id="producir" icon="fas fa-industry" title="Pasar a producción"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>