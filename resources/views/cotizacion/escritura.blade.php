<x-adminlte-modal id="modalEscritura" title="Guardado de Variantes de Modelos" size="xl" theme="primary" icon="fas fa-shoe-prints" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary bg-light p-1 rounded text-center"><b><i class="fas fa-info-circle"></i> Elige la variante de modelo en la que deseas sobreescribir la nueva variante de modelo. De lo contrario, pulsa solamente el botón de "<i class="fas fa-save"></i> Guardar" </b></p>
        <form novalidate>
            <div class="container-fluid row">
                <p class="col-lg-12 p-1 bg-info"><b>Datos de Nueva Variante de Modelo</b></p>
                <div class="col-lg-3">
                    <x-adminlte-input class="mx-1" name="modeloVariante" id="modeloVariante" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-shoe-prints"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-3">
                    <x-adminlte-input class="mx-1" name="numeroVariante" id="numeroVariante" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-hashtag"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-lg-6">
                    <x-adminlte-input class="mx-1" name="descripcionVariante" id="descripcionVariante">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <input type="hidden" name="idModeloVariante" id="idModeloVariante">
                <input type="hidden" name="cadenaVariante" id="cadenaVariante">
                <input type="hidden" name="cotizacionVariante" id="cotizacionVariante">
            </div>
            <div class="form-group container-fluid">
                @php
                    $heads = ['Modelo', 'Número', 'Descripción', ''];
                @endphp
                <x-adminlte-datatable id="contenedorVariantes" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                </x-adminlte-datatable>
            </div>
            <input type="hidden" name="idModeloVariante" id="idModeloVariante" >
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar" id="guardarVariante" icon="fas fa-save"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>