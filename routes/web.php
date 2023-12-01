<?php

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

Route::get('/welcome', function () {
    return view('welcome');
});
Route::any('/', 'FilaController@index')->name('fila.index');
Route::post('/atualizar-ordem/{itemId}/{newIndex}', 'FilaController@atualizar-ordem')->name('fila.update');
