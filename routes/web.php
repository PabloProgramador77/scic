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