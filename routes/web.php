<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::post('material/colores', [App\Http\Controllers\MaterialController::class, 'create'])->name('colores-material');

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

Route::get('costes', [App\Http\Controllers\CosteController::class, 'index'])->name('costes');
Route::post('coste/agregar', [App\Http\Controllers\CosteController::class, 'store'])->name('agregar-coste');
Route::post('coste/buscar', [App\Http\Controllers\CosteController::class, 'show'])->name('buscar-coste');
Route::post('coste/actualizar', [App\Http\Controllers\CosteController::class, 'update'])->name('actualizar-coste');
Route::post('coste/borrar', [App\Http\Controllers\CosteController::class, 'destroy'])->name('borrar-coste');

Route::get('modelos', [App\Http\Controllers\ModeloController::class, 'index'])->name('modelos');
Route::post('modelo/agregar', [App\Http\Controllers\ModeloController::class, 'store'])->name('agregar-modelo');
Route::post('modelo/buscar', [App\Http\Controllers\ModeloController::class, 'show'])->name('buscar-modelo');
Route::post('modelo/actualizar', [App\Http\Controllers\ModeloController::class, 'update'])->name('actualizar-modelo');
Route::post('modelo/borrar', [App\Http\Controllers\ModeloController::class, 'destroy'])->name('borrar-modelo');
Route::get('modelo/piezas/{id}', [App\Http\Controllers\ModeloController::class, 'create'])->name('piezas-modelo');
Route::post('modelo/piezas', [App\Http\Controllers\ModelHasPiezaController::class, 'store'])->name('modelo-piezas');
Route::post('modelo/costos', [App\Http\Controllers\ModeloHasCostoController::class, 'index'])->name('modelo-costos');
Route::post('modelo/costos/agregar', [App\Http\Controllers\ModeloHasCostoController::class, 'store'])->name('agregar-costos');
Route::post('modelo/costos/buscar', [App\Http\Controllers\ModeloHasCostoController::class, 'show'])->name('buscar-costos-modelo');
Route::post('modelo/consumibles', [App\Http\Controllers\ModeloHasConsumibleController::class, 'index'])->name('modelo-consumibles');
Route::post('modelo/consumibles/agregar', [App\Http\Controllers\ModeloHasConsumibleController::class, 'store'])->name('agregar-consumibles');
Route::post('modelo/consumibles/buscar', [App\Http\Controllers\ModeloHasConsumibleController::class, 'show'])->name('buscar-consumibles-modelo');
Route::post('modelo/suelas', [App\Http\Controllers\ModeloHasSuelaController::class, 'index'])->name('modelo-suelas');
Route::post('modelo/suelas/agregar', [App\Http\Controllers\ModeloHasSuelaController::class, 'store'])->name('agregar-suelas-modelo');
Route::post('modelo/suelas/buscar', [App\Http\Controllers\ModeloHasSuelaController::class, 'show'])->name('buscar-suelas-modelo');
Route::post('modelo/numeraciones', [App\Http\Controllers\ModeloHasNumeracionesController::class, 'index'])->name('modelo-numeraciones');
Route::post('modelo/numeraciones/agregar', [App\Http\Controllers\ModeloHasNumeracionesController::class, 'store'])->name('agregar-numeraciones-modelo');
Route::post('modelo/costes', [App\Http\Controllers\ModeloHasCosteController::class, 'index'])->name('modelo-costes');
Route::post('modelo/costes/agregar', [App\Http\Controllers\ModeloHasCosteController::class, 'store'])->name('agregar-costes');
Route::post('modelo/costes/buscar', [App\Http\Controllers\ModeloHasCosteController::class, 'show'])->name('buscar-costes-modelo');
Route::post('modelo/encriptar', [App\Http\Controllers\ModeloController::class, 'encriptacion'])->name('encriptar-modelo');
Route::post('modelo/ganancia', [App\Http\Controllers\ModeloHasGananciaController::class, 'store'])->name('ganancia-modelos');
Route::post('modelo/ganancia/buscar', [App\Http\Controllers\ModeloHasGananciaController::class, 'show'])->name('buscar-ganancia-modelos');
Route::post('modelo/punto', [App\Http\Controllers\ModeloController::class, 'punto'])->name('punto-menor-modelo');

Route::get('cotizaciones', [App\Http\Controllers\CotizacionController::class, 'index'])->name('cotizaciones');
Route::get('cotizador/cliente/{idCliente}', [App\Http\Controllers\CotizacionController::class, 'create'])->name('cotizador');
Route::post('modelo/cotizacion', [App\Http\Controllers\CotizacionController::class, 'show'])->name('modelo-cotizacion');
Route::post('cotizacion/agregar', [App\Http\Controllers\CotizacionController::class, 'store'])->name('agregar-cotizacion');
Route::post('cotizacion/borrar', [App\Http\Controllers\CotizacionController::class, 'destroy'])->name('borrar-cotizacion');
Route::post('/cotizacion/cliente', [App\Http\Controllers\CotizacionController::class, 'assign'])->name('cliente-cotizacion');
Route::post('cotizacion/numeraciones', [App\Http\Controllers\CotizacionHasNumeracionesController::class, 'store'])->name('cotizacion-numeraciones');
Route::get('cotizaciones/cliente/{idCliente}', [App\Http\Controllers\CotizacionController::class, 'cliente'])->name('cotizaciones-cliente');
Route::get('cotizacion/ver/{idCotizacion}', [App\Http\Controllers\CotizacionController::class, 'cotizacion'])->name('ver-cotizacion');
Route::post('cotizacion/variante', [App\Http\Controllers\CotizacionController::class, 'encriptacion'])->name('variante-cotizacion');
Route::post('cotizacion/variante/agregar', [App\Http\Controllers\CotizacionController::class, 'nuevoModelo'])->name('agregar-variante-modelo');
Route::post('cotizacion/variante/sobreescribir', [App\Http\Controllers\CotizacionController::class, 'sobreescribirModelo'])->name('sobreescribir-variante-modelo');
Route::get('cotizacion/editar/{id}', [App\Http\Controllers\CotizacionController::class, 'editar'])->name('editar-cotizacion');
Route::post('cotizacion/copiar', [App\Http\Controllers\CotizacionController::class, 'copiar'])->name('copiar-cotizacion');
Route::post('cotizacion/actualizar', [App\Http\Controllers\CotizacionController::class, 'actualizar'])->name('actualizar-cotizacion');

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

Route::get('/notas', [App\Http\Controllers\NotaController::class, 'index'])->name('notas');
Route::post('/nota/agregar', [App\Http\Controllers\NotaController::class, 'store'])->name('agregar-nota');
Route::post('/nota/cotizacion', [App\Http\Controllers\NotaHasCotizacionController::class, 'create'])->name('cotizacion-nota');
Route::post('/nota/borrar', [App\Http\Controllers\NotaController::class, 'destroy'])->name('borrar-nota');
Route::post('/nota/buscar', [App\Http\Controllers\NotaController::class, 'show'])->name('buscar-nota');
Route::post('/nota/cotizacion/borrar', [App\Http\Controllers\NotaHasCotizacionController::class, 'destroy'])->name('borrar-cotizacion-nota');
Route::get('/nota/editar/{id}/{idCliente}', [App\Http\Controllers\NotaController::class, 'edit'])->name('editar-nota');
Route::get('/nota/ver/{id}/{idCliente}', [App\Http\Controllers\NotaController::class, 'nota'])->name('ver-nota');
Route::post('/nota/descarga', [App\Http\Controllers\NotaController::class, 'descarga'])->name('descarga-nota');
Route::get('/nota/descargar/{id}', [App\Http\Controllers\NotaController::class, 'descargar'])->name('descargar-nota');
Route::post('/nota/anticipar', [App\Http\Controllers\NotaController::class, 'anticipar'])->name('anticipar-nota');
Route::post('/nota/cerrar', [App\Http\Controllers\NotaController::class, 'cerrar'])->name('cerrar-nota');
Route::get('/notas/cliente/{idCliente}', [App\Http\Controllers\NotaController::class, 'cliente'])->name('notas-cliente');
Route::post('/nota/impuestos', [App\Http\Controllers\NotaController::class, 'impuestos'])->name('impuestos-nota');
Route::post('/nota/consumos', [App\Http\Controllers\NotaController::class, 'consumos'])->name('consumos-nota');
Route::get('/nota/consumos/{idNota}', [App\Http\Controllers\NotaController::class, 'consumo'])->name('descargar-consumos');
Route::get('/notas/tabla/{idNota}', [App\Http\Controllers\NotaController::class, 'tabla'])->name('tabla-consumos');
Route::post('/notas/tabla', [App\Http\Controllers\NotaController::class, 'tablaConsumo'])->name('tabla-consumo');
Route::post('/nota/viajera', [App\Http\Controllers\NotaController::class, 'viajeras'])->name('hojas-viajeras');
Route::get('/notas/viajera/{id}', [App\Http\Controllers\NotaController::class, 'viajera'])->name('hoja-viajera');

Route::get('/numeraciones', [App\Http\Controllers\NumeracionController::class, 'index'])->name('numeraciones');
Route::post('/numeracion/agregar', [App\Http\Controllers\NumeracionController::class, 'store'])->name('agregar-numeracion');
Route::post('/numeracion/buscar', [App\Http\Controllers\NumeracionController::class, 'show'])->name('buscar-numeracion');
Route::post('/numeracion/actualizar', [App\Http\Controllers\NumeracionController::class, 'update'])->name('actualizar-numeracion');
Route::post('/numeracion/borrar', [App\Http\Controllers\NumeracionController::class, 'destroy'])->name('borrar-numeracion');

Route::post('/cliente/agregar', [App\Http\Controllers\ClienteController::class, 'index'])->name('agregar-cliente');
Route::post('/cliente/buscar', [App\Http\Controllers\ClienteController::class, 'show'])->name('buscar-cliente');
Route::post('/cliente/actualizar', [App\Http\Controllers\ClienteController::class, 'update'])->name('actualizar-cliente');
Route::post('/cliente/borrar', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('borrar-cliente');

Route::get('/suajes', [App\Http\Controllers\SuajeController::class, 'index'])->name('suajes');
Route::post('/suaje/agregar', [App\Http\Controllers\SuajeController::class, 'store'])->name('agregar-suaje');
Route::post('/suaje/actualizar', [App\Http\Controllers\SuajeController::class, 'update'])->name('actualizar-suaje');
Route::post('/suaje/borrar', [App\Http\Controllers\SuajeController::class, 'destroy'])->name('borrar-suaje');

Route::get('/procesos', [App\Http\Controllers\ProcesoController::class, 'index'])->name('procesos');
Route::post('/proceso/agregar', [App\Http\Controllers\ProcesoController::class, 'store'])->name('agregar-proceso');
Route::post('/proceso/actualizar', [App\Http\Controllers\ProcesoController::class, 'update'])->name('actualizar-proceso');
Route::post('/proceso/borrar', [App\Http\Controllers\ProcesoController::class, 'destroy'])->name('borrar-proceso');
Route::post('/actividad/agregar', [App\Http\Controllers\ActividadController::class, 'store'])->name('agregar-actividad');
Route::post('/actividad/actualizar', [App\Http\Controllers\ActividadController::class, 'update'])->name('actualizar-actividad');
Route::post('/actividad/borrar', [App\Http\Controllers\ActividadController::class, 'destroy'])->name('borrar-actividad');
Route::get('/actividades', [App\Http\Controllers\ActividadController::class, 'index'])->name('actividades');