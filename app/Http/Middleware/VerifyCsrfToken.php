<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        
        'usuario/agregar',
        'usuario/buscar',
        'usuario/actualizar',
        'usuario/borrar',
        'role/agregar',
        'role/buscar',
        'role/actualizar',
        'role/borrar',
        'role/permisos',
        'permiso/agregar',
        'permiso/buscar',
        'permiso/actualizar',
        'permiso/borrar',
        'material/agregar',
        'material/actualizar',
        'material/borrar',
        'material/buscar',
        'material/colores',
        'proveedor/agregar',
        'proveedor/actualizar',
        'proveedor/borrar',
        'proveedor/buscar',
        'pieza/agregar',
        'pieza/actualizar',
        'pieza/borrar',
        'pieza/buscar',
        'costo/agregar',
        'costo/buscar',
        'costo/actualizar',
        'costo/borrar',
        'coste/agregar',
        'coste/buscar',
        'coste/actualizar',
        'coste/borrar',
        'modelo/agregar',
        'modelo/buscar',
        'modelo/actualizar',
        'modelo/borrar',
        'modelo/piezas',
        'modelo/cotizacion',
        'modelo/costos',
        'modelo/costos/agregar',
        'modelo/costos/buscar',
        'modelo/costes',
        'modelo/costes/agregar',
        'modelo/costes/buscar',
        'modelo/consumibles',
        'modelo/consumibles/agregar',
        'modelo/consumibles/buscar',
        'modelo/suelas',    
        'modelo/suelas/agregar',
        'modelo/suelas/buscar',
        'modelo/encriptar',
        'modelo/ganancia',
        'modelo/ganancia/buscar',
        'modelo/punto',
        'consumible/agregar',
        'consumible/buscar',
        'consumible/actualizar',
        'consumible/borrar',
        'suela/agregar',
        'suela/buscar',
        'suela/actualizar',
        'suela/borrar',
        'cotizacion/agregar',
        'cotizacion/borrar',
        'cotizacion/numeraciones',
        'cotizacion/variante',
        'cotizacion/variante/agregar',
        'cotizacion/variante/sobreescribir',
        'cotizacion/copiar',
        'nota/agregar',
        'cotizacion/cliente',
        'nota/cotizacion',
        'nota/borrar',
        'nota/buscar',
        'nota/cotizacion/borrar',
        'numeracion/agregar',
        'numeracion/buscar',
        'numeracion/actualizar',
        'numeracion/borrar',
        'modelo/numeraciones',
        'modelo/numeraciones/agregar',
        'notas/cliente',
        'nota/descarga',
        'nota/anticipar',
        'nota/cerrar',
        'cliente/agregar',
        'cliente/buscar',
        'cliente/actualizar',
        'cliente/borrar',
        'nota/impuestos',
        'nota/consumos',
        'notas/tabla',
        'nota/viajera',
        'suaje/agregar',
        'suaje/buscar',
        'suaje/actualizar',
        'suaje/borrar',
        'proceso/agregar',
        'proceso/actualizar',
        'proceso/borrar',
        'actividad/agregar',
        'actividad/actualizar',
        'actividad/borrar',
        
    ];
}
