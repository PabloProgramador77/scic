<x-adminlte-modal id="modalClientes" title="Clientes registrados" size="xl" theme="secondary" icon="fas fa-users" static-backdrop scrollable>
    <div class="container-fluid row">
        <div class="col-lg-12 col-md-12 border rounded">
            <input type="hidden" name="idCliente" id="idCliente">
            <p class="text-center bg-warning p-1 rounded"><i class="fas fa-info-circle"></i> Elige el cliente destino de las cotizaciones elegidas.</p>
            @php
                $heads = ['N°', 'Cliente', 'Telefono', 'Email', ''];
            @endphp
            <x-adminlte-datatable id="contenedorclientes" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                @if ( count( $clientes ) > 0 )
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>
                                <a class="btn btn-info rounded cliente" id="cliente{{ $cliente->id }}" data-id="{{ $cliente->id }}"><i class="fas fa-paste"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger"><i class="fas fa-info-circle"></i> Sin clientes registrados.</td>
                    </tr>
                @endif
            </x-adminlte-datatable>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" label=" Cerrar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
            </x-slot>
        </div>
    </div>
    
</x-adminlte-modal>