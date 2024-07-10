<x-adminlte-modal id="modalConsumible" title="Consumibles de Modelo" size="xl" theme="secondary" icon="fas fa-socks" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary bg-light p-1 rounded text-center"><b><i class="fas fa-info-circle"></i> Elige los consumibles a agregar a la cotización</b></p>
        <form novalidate>
            <div class="form-group container-fluid">
                @php
                    $heads = [ '', 'Consumible', 'Tipo', 'Total' ];
                @endphp
                <x-adminlte-datatable id="contenedorConsumibles" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModelo" id="idModelo" value="{{ $modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Continuar" id="agregarConsumible" icon="fas fa-arrow-circle-right"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Regresar" id="cancelarConsumible" data-dismiss="modal" icon="fas fa-undo-alt"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>