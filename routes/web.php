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

Route::view('emissao_sincrona', 'emissao_sincrona');
Route::view('cancelamento', 'cancelar');

Route::get('emitir_sincrono', 'App\Http\Controllers\EmissaoSincrona@enviar');
Route::get('cancelar', 'App\Http\Controllers\Cancelar@enviar');