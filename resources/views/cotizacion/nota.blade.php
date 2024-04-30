<x-adminlte-modal id="modalNota" title="Nueva Nota" size="xl" theme="success" icon="fas fa-plus" static-backdrop scrollable>
    <div class="container-fluid row">
        <p class="col-lg-12 text-center bg-light fw-semibold p-1 rounded"><i class="fas fa-info-circle"></i> <b>Captura los datos para un cliente nuevo o elige uno de los ya registrados en la tabla de la derecha</b>.</p>
        <div class="col-lg-3 col-md-3 border rounded">
            <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
            <form novalidate>
                <div class="form-group">
                    <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de cliente">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-user">*</i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="form-group">
                    <x-adminlte-input name="telefono" id="telefono" placeholder="Teléfono de cliente">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-phone"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="form-group">
                    <x-adminlte-input name="domicilio" id="domicilio" placeholder="Domicilio de cliente">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="form-group">
                    <x-adminlte-input name="email" id="email" placeholder="Correo electrónico de cliente">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-info">
                                <i class="fas fa-mail"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </form>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="primary" label=" Crear" id="registrar" icon="fas fa-save"></x-adminlte-button>
                <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
            </x-slot>
        </div>
        <div class="col-lg-9 col-md-9 border rounded">
            <p class="text-secondary">Elige el cliente para la nota.</p>
            @php
                $heads = ['Cliente', 'Telefono', 'Domicilio', 'Email', ''];
            @endphp
            <x-adminlte-datatable id="cliente" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                @if ( count( $clientes ) > 0 )
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->domicilio }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>
                                <a href="{{ url('/nota/cliente') }}/{{ $cliente->id }}" class="btn btn-info rounded cliente" id="cliente"><i class="fab fa-gratipay"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-danger"><i class="fas fa-info-circle"></i> Sin clientes registrados.</td>
                    </tr>
                @endif
            </x-adminlte-datatable>
        </div>
    </div>
    
</x-adminlte-modal>