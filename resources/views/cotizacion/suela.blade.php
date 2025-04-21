<x-adminlte-modal id="modalSuela" title="Suelas de Modelo" size="xl" theme="primary" icon="fas fa-shoe-prints" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary bg-light p-1 rounded text-center"><b><i class="fas fa-info-circle"></i> Elige la(s) suela(s) a agregar a la cotización</b></p>
        <form novalidate>
            <div class="form-group container-fluid">
                @php
                    $heads = [ '', 'Suela', 'Precio', 'Descripción' ];
                    $config = ['order' => [[1, 'asc']], 'pageLength' => [100], 'lengthMenu' => [10, 25, 50, 75, 100]];
                @endphp
                <x-adminlte-datatable id="contenedorSuelas" :heads="$heads" :config="$config" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModelo" id="idModelo" value="{{ $cotizacion->modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Terminar" id="preeliminar" icon="fas fa-file" data-toggle="modal" data-target="#modalPreeliminar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Regresar" id="cancelarSuela" data-dismiss="modal" icon="fas fa-undo-alt"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>