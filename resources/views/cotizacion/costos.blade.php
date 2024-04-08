<x-adminlte-modal id="modalCostos" title="Costos Base y Neutros" theme="warning" icon="fas fa-dollar-sign" static-backdrop scrollable size="xl">
    <div class="container-fluid border-bottom">
        <p class="text-secondary bg-light p-1 rounded"><i class="fas fa-info-circle"></i> Elige los costos a agregar a la cotización.</p>
        <form novalidate>
            <div class="form-group">
                @php
                    $heads = ['', 'Costo', 'Tipo', 'Total']
                @endphp

                <x-adminlte-datatable id="contenedorCostos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                    <tr>
                        <td colspan="12" class="fw-semibold text-center bg-light"><i class="fas fa-info-circle"></i> Elige un modelo para observar los costos.</td>
                    </tr>

                </x-adminlte-datatable>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Agregar" id="agregar" icon="fas fa-save" disabled="true"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>