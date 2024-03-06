<x-adminlte-modal id="modalPermisos" title="Permisos de Rol de Usuario" size="xl" theme="secondary" icon="fas fa-user-cog" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige los permisos que deseas agregar al rol de usuario.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreRol" id="nombreRol" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Permisos</p>
            <div class="form-group row">

                @if ( count( $permisos ) > 0 )
                    @foreach($permisos as $permiso)

                    <div class="col-md-6 col-lg-3">
                        <x-adminlte-input-switch id="permiso{{ $permiso->id }}" name="permiso" label="{{ $permiso->name }}" data-on-text="Permiso de {{ $permiso->name }}" data-off-text="Sin permiso de {{ $permiso->name }}" data-id="{{ $permiso->name }}">
                        </x-adminlte-input-switch>
                    </div>

                    @endforeach
                @else
                    <div class="col-12">
                        <p class="fw-semibold fs-5 text-center">Sin permisos de usuario registrados. <a href="{{ url('/permisos') }}">Agregar permisos ahora</a></p>
                    </div>
                @endif
                
            </div>
            <input type="hidden" name="idRolPermiso" id="idRolPermiso">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>