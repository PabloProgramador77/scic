<x-adminlte-modal id="modalSuela" title="Suelas para Modelo" size="xl" theme="info" icon="fas fa-shoe-prints" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <div class="row col-lg-12 col-md-12 col-sm-12 p-1 m-1">
            <p class="text-info bg-light p-2 rounded text-center col-lg-10 col-md-8 col-sm-12 m-1"><b><i class="fas fa-info-circle"></i> Elige la suela que deseas agregar el modelo actual o si es necesario agrega una nueva presiona el botón "+ Suela"</b></p>
            <x-adminlte-button id="nuevoSuela" theme="primary" icon="fas fa-plus-circle" label=" Suela" data-toggle="modal" data-target="#modalNuevoSuela" class="m-1"></x-adminlte-button>
        </div>
        <form novalidate class="container-fluid row">
            <div class="form-group">
                <x-adminlte-input name="nombreModeloSuela" id="nombreModeloSuela" readonly="true" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-secondary">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="form-group container-fluid">
                @php
                    $heads = [ '', 'Suela', 'Proveedor', 'Precio', 'Descripción' ];
                    $config = ['order' => [[1, 'asc']], 'pageLength' => [100], 'lengthMenu' => [10, 25, 50, 75, 100]];
                @endphp
                <x-adminlte-datatable id="contenedorSuelas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModeloSuela" id="idModeloSuela" value="{{ $modelo->id }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregarSuela" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>