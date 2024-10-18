<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\RequerimientoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('equipos', EquipoController::class);
Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/productos', function () {
    return view('productos/index'); 
});

Route::get('/requerimientos', function () {
    return view('requerimientos/index'); 
});
Route::get('/dispositivos', [App\Http\Controllers\DispositivoController::class, 'index'])->name('dispositivos.index');
Route::get('/api/data', [DataController::class, 'index']);
Route::post('/api/productos', [App\Http\Controllers\DispositivoController::class, 'store']);
Route::post('/api/productos/masivo', [App\Http\Controllers\DispositivoController::class, 'storeMasivo']);
Route::get('/api/unidades', [UnidadController::class, 'index']);
Route::post('/api/requerimientos', [RequerimientoController::class, 'store']);
Route::get('/requerimientos/obt', [RequerimientoController::class, 'index']);
});//fin del middleware