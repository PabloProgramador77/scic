<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

Route::get('permisos', [App\Http\Controllers\PermisoController::class, 'index'])->name('permisos');
Route::post('permiso/agregar', [App\Http\Controllers\PermisoController::class, 'store'])->name('agregar-permiso');
Route::post('permiso/buscar', [App\Http\Controllers\PermisoController::class, 'show'])->name('buscar-permiso');
Route::post('permiso/actualizar', [App\Http\Controllers\PermisoController::class, 'update'])->name('actualizar-permiso');
Route::post('permiso/borrar', [App\Http\Controllers\PermisoController::class, 'destroy'])->name('borrar-permiso');