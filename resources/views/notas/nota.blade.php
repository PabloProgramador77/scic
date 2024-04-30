<x-adminlte-modal id="modalNota" title="Detalles de Nota" size="xl" theme="primary" icon="fas fa-list" static-backdrop scrollable>
    <div class="container-fluid row">
        <div class="container-fluid border rounded">
            <input type="hidden" name="idNota" id="idNota">
            <p class="col-lg-12 col-md-12 text-center bg-light p-1 rounded"><i class="fas fa-info-circle"></i> Elige la cotización de la nota a borrar.</p>
            <div class="container-fluid row">
                <x-adminlte-input class="col-lg-6 col-md-6" name="nota" id="nota" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-file-invoice-dollar"> Folio</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input class="col-lg-6 col-md-6" name="cliente" id="cliente" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-user"> Cliente</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input class="col-lg-6 col-md-6" name="total" id="total" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign"> Total</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <a href="#" class="btn btn-secondary"><i class="fas fa-print"></i></a>
            </div>
            @php
                $heads = ['Folio', 'Modelo', 'Precio Unitario', ''];
            @endphp
            <x-adminlte-datatable id="contenedorCotizaciones" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                @if ( count( $cotizaciones ) > 0 )
                    @foreach ($cotizaciones as $cotizacion)
                        <tr>
                            <td>{{ $cotizacion->id }}</td>
                            <td>{{ $cotizacion->modelo->nombre }}</td>
                            <td>$ {{ $cotizacion->precio }}</td>
                            <td>
                                <a class="btn btn-danger rounded borrar" id="cotizacion{{ $cotizacion->id }}" data-id="{{ $cotizacion->id }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger"><i class="fas fa-info-circle"></i> Sin cotizaciones registradas.</td>
                    </tr>
                @endif
            </x-adminlte-datatable>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" label=" Cerrar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
            </x-slot>
        </div>
    </div>
    
</x-adminlte-modal>