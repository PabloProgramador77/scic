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