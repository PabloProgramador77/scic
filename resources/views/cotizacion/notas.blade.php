<x-adminlte-modal id="modalNotas" title="Notas Creadas" size="xl" theme="primary" icon="fas fa-plus" static-backdrop scrollable>
    <div class="container-fluid row">
        <div class="col-lg-12 col-md-12 border rounded">
            <input type="hidden" name="idCotizacion" id="idCotizacion">
            <p class="text-center bg-light p-1 rounded"><i class="fas fa-info-circle"></i> Elige la nota en la que deseas agregar la cotización.</p>
            @php
                $heads = ['Folio', 'Cliente', 'Total de Nota', 'Estado', ''];
            @endphp
            <x-adminlte-datatable id="notas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                @if ( count( $notas ) > 0 )
                    @foreach ($notas as $nota)
                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->cliente->nombre }}</td>
                            <td>$ {{ $nota->total }}</td>
                            <td>{{ $nota->estado }}</td>
                            <td>
                                <a class="btn btn-info rounded nota" id="nota{{ $nota->id }}" data-id="{{ $nota->id }}"><i class="fas fa-file-invoice-dollar"></i></a>
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