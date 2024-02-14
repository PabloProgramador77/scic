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
        'permiso/agregar',
        'permiso/buscar',
        'permiso/actualizar',
        'permiso/borrar',
        
    ];
}
