<x-adminlte-modal id="modalSuela" title="Suelas de Modelo" size="xl" theme="primary" icon="fas fa-shoe-prints" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary bg-light p-1 rounded text-center"><b><i class="fas fa-info-circle"></i> Elige la(s) suela(s) a agregar a la cotización</b></p>
        <form novalidate>
            <div class="form-group container-fluid">
                @php
                    $heads = [ '', 'Suela', 'Precio', 'Descripción' ];
                @endphp
                <x-adminlte-datatable id="contenedorSuelas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModelo" id="idModelo" value="{{ $modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregarSuela" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>