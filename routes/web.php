<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios');
Route::post('usuario/agregar', [App\Http\Controllers\UsuarioController::class, 'store'])->name('agregar-usuario');
Route::post('usuario/buscar', [App\Http\Controllers\UsuarioController::class, 'show'])->name('buscar-usuario');
Route::post('usuario/actualizar', [App\Http\Controllers\UsuarioController::class, 'update'])->name('actualizar-usuario');
Route::post('usuario/borrar', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('borrar-usuario');

Route::get('roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
Route::post('role/agregar', [App\Http\Controllers\RoleController::class, 'store'])->name('agregar-role');
Route::post('role/buscar', [App\Http\Controllers\RoleController::class, 'show'])->name('buscar-role');
Route::post('role/actualizar', [App\Http\Controllers\RoleController::class, 'update'])->name('actualizar-role');
Route::post('role/borrar', [App\Http\Controllers\RoleController::class, 'destroy'])->name('borrar-role');
Route::post('role/permisos', [App\Http\Controllers\RoleController::class, 'create'])->name('permisos-role');

Route::get('permisos', [App\Http\Controllers\PermisoController::class, 'index'])->name('permisos');
Route::post('permiso/agregar', [App\Http\Controllers\PermisoController::class, 'store'])->name('agregar-permiso');
Route::post('permiso/buscar', [App\Http\Controllers\PermisoController::class, 'show'])->name('buscar-permiso');
Route::post('permiso/actualizar', [App\Http\Controllers\PermisoController::class, 'update'])->name('actualizar-permiso');
Route::post('permiso/borrar', [App\Http\Controllers\PermisoController::class, 'destroy'])->name('borrar-permiso');

Route::get('materiales', [App\Http\Controllers\MaterialController::class, 'index'])->name('materiales');
Route::post('material/agregar', [App\Http\Controllers\MaterialController::class, 'store'])->name('agregar-material');
Route::post('material/buscar', [App\Http\Controllers\MaterialController::class, 'show'])->name('buscar-material');
Route::post('material/actualizar', [App\Http\Controllers\MaterialController::class, 'update'])->name('actualizar-material');
Route::post('material/borrar', [App\Http\Controllers\MaterialController::class, 'destroy'])->name('borrar-material');

Route::get('proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('proveedores');
Route::post('proveedor/agregar', [App\Http\Controllers\ProveedorController::class, 'store'])->name('agregar-proveedor');
Route::post('proveedor/buscar', [App\Http\Controllers\ProveedorController::class, 'show'])->name('buscar-proveedor');
Route::post('proveedor/actualizar', [App\Http\Controllers\ProveedorController::class, 'update'])->name('actualizar-proveedor');
Route::post('proveedor/borrar', [App\Http\Controllers\ProveedorController::class, 'destroy'])->name('borrar-proveedor');

Route::get('piezas', [App\Http\Controllers\PiezaController::class, 'index'])->name('piezas');
Route::post('pieza/agregar', [App\Http\Controllers\PiezaController::class, 'store'])->name('agregar-pieza');
Route::post('pieza/buscar', [App\Http\Controllers\PiezaController::class, 'show'])->name('buscar-pieza');
Route::post('pieza/actualizar', [App\Http\Controllers\PiezaController::class, 'update'])->name('actualizar-pieza');
Route::post('pieza/borrar', [App\Http\Controllers\PiezaController::class, 'destroy'])->name('borrar-pieza');

Route::get('costos', [App\Http\Controllers\CostoController::class, 'index'])->name('costos');
Route::post('costo/agregar', [App\Http\Controllers\CostoController::class, 'store'])->name('agregar-costo');
Route::post('costo/buscar', [App\Http\Controllers\CostoController::class, 'show'])->name('buscar-costo');
Route::post('costo/actualizar', [App\Http\Controllers\CostoController::class, 'update'])->name('actualizar-costo');
Route::post('costo/borrar', [App\Http\Controllers\CostoController::class, 'destroy'])->name('borrar-costo');

Route::get('modelos', [App\Http\Controllers\ModeloController::class, 'index'])->name('modelos');
Route::post('modelo/agregar', [App\Http\Controllers\ModeloController::class, 'store'])->name('agregar-modelo');
Route::post('modelo/buscar', [App\Http\Controllers\ModeloController::class, 'show'])->name('buscar-modelo');
Route::post('modelo/actualizar', [App\Http\Controllers\ModeloController::class, 'update'])->name('actualizar-modelo');
Route::post('modelo/borrar', [App\Http\Controllers\ModeloController::class, 'destroy'])->name('borrar-modelo');
Route::get('modelo/piezas/{id}', [App\Http\Controllers\ModeloController::class, 'create'])->name('piezas-modelo');
Route::post('modelo/piezas', [App\Http\Controllers\ModelHasPiezaController::class, 'store'])->name('modelo-piezas');

Route::get('cotizacion', [App\Http\Controllers\NotaController::class, 'index'])->name('cotizacion');
Route::post('modelo/cotizacion', [App\Http\Controllers\NotaController::class, 'create'])->name('modelo-cotizacion');

Route::get('consumibles', [App\Http\Controllers\ConsumibleController::class, 'index'])->name('consumibles');
Route::post('consumible/agregar', [App\Http\Controllers\ConsumibleController::class, 'store'])->name('agregar-consumible');
Route::post('consumible/buscar', [App\Http\Controllers\ConsumibleController::class, 'show'])->name('buscar-consumible');
Route::post('consumible/actualizar', [App\Http\Controllers\ConsumibleController::class, 'update'])->name('actualizar-consumible');
Route::post('consumible/borrar', [App\Http\Controllers\ConsumibleController::class, 'destroy'])->name('borrar-consumible');

Route::get('suelas', [App\Http\Controllers\SuelaController::class, 'index'])->name('suelas');
Route::post('suela/agregar', [App\Http\Controllers\SuelaController::class, 'store'])->name('agregar-suela');
Route::post('suela/buscar', [App\Http\Controllers\SuelaController::class, 'show'])->name('buscar-suela');
Route::post('suela/actualizar', [App\Http\Controllers\SuelaController::class, 'update'])->name('actualizar-suela');
Route::post('suela/borrar', [App\Http\Controllers\SuelaController::class, 'destroy'])->name('borrar-suela');