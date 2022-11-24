<?php

use Illuminate\Support\Facades\Route;

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

// IMPORTAÇÃO DO CONTROLER
use App\Http\Controllers\EventController;

// DESTINO, [CONTROLLER UTILIZADO::class, 'ACTION']
Route::get('/', [EventController::class, 'index']);                 // index p/ mostrar todos os registros
Route::get('/events/create', [EventController::class, 'create']);   // create p/ mostrar o formulário de criar registro no Banco
Route::get('/events/{id}', [EventController::class, 'show']);       // show p/ mostrar dado específico
Route::post("/events", [EventController::class, 'store']);          // store p/ enviar dados ao Banco

Route::get('/contact', function () {
    return view('contact');
});
