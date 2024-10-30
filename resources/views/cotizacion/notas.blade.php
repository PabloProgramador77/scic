<x-adminlte-modal id="modalNotas" title="Notas Creadas" size="xl" theme="primary" icon="fas fa-file" static-backdrop scrollable>
    <div class="container-fluid row">
        <div class="col-lg-12 col-md-12 border rounded">
            <input type="hidden" name="idCotizacion" id="idCotizacion">
            <p class="text-center bg-warning p-1 rounded"><i class="fas fa-info-circle"></i> Elige la nota en la que deseas agregar la cotización. Solo a las notas pendientes se les puede agregar cotizaciones.</p>
            @php
                $heads = ['Folio', 'Total de Pares', 'Total de Nota', 'Estado', ''];
            @endphp
            <x-adminlte-datatable id="contenedorNotas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                @if ( count( $notas ) > 0 )
                    @foreach ($notas as $nota)
                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->pares }}</td>
                            <td>$ {{ $nota->total }}</td>
                            <td><span class="p-1 rounded bg-teal">{{ $nota->estado }}</span></td>
                            <td>
                                @if( $nota->estado == 'Pendiente')
                                    <a class="btn btn-info rounded nota" id="nota{{ $nota->id }}" data-id="{{ $nota->id }}"><i class="fas fa-plus-circle"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger"><i class="fas fa-info-circle"></i> Sin notas registradas.</td>
                    </tr>
                @endif
            </x-adminlte-datatable>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" label=" Cerrar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
            </x-slot>
        </div>
    </div>
    
</x-adminlte-modal>