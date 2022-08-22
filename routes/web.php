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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sequencia/roleta',[\App\Http\Controllers\Pages\Games\Roleta::class,"index"])->name('double.criar');
Route::get('/blaze/double/sequencias',[\App\Http\Controllers\Pages\Games\Roleta::class,"sequencias"])->name('double.sequencias');

Route::post('/ajax/criar-sequencia',[\App\Http\Controllers\Jogos\Blaze\Double\Criar\SequenciaDouble::class,'index'])->name('sequencia.criar');


// WebHook Telegram


