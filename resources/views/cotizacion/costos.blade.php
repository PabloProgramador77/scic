<x-adminlte-modal id="modalCostos" title="Costos Base y Neutros" theme="warning" icon="fas fa-dollar-sign" static-backdrop scrollable size="xl">
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige los costos a agregar a la cotización.</p>
        <form novalidate>
            <div class="form-group">
                @php
                    $heads = ['', 'Costo', 'Tipo', 'Descripción', 'Monto']
                @endphp

                <x-adminlte-datatable id="contenedorCostos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>

                    @if( count( $costos ) > 0 )
                        @foreach( $costos as $costo)
                            <tr>
                                <td>
                                    <input type="checkbox" name="costo" id="costo" class="form-control" value="{{ $costo->total }}">
                                </td>
                                <td>{{ $costo->nombre }}</td>
                                <td>{{ $costo->tipo }}</td>
                                @if( $costo->descripcion == '' )
                                    <td>Descripción desconocida</td>
                                @else
                                    <td>{{ $costo->descripcion }}</td>
                                @endif
                                <td>${{ $costo->total }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="fw-semibold">No hay costos registrados. Por favor, registralos en <a href="url('costos')">este enlace.</a></td>
                        </tr>
                    @endif

                </x-adminlte-datatable>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Agregar" id="agregar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>