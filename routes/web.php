<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/',function (){
   return view('pages.home.home');
});

//////////////////////////////////////////////////////////////////////////////////////////////////////
///  ADMIN
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sequencia/roleta',[\App\Http\Controllers\Pages\Games\Roleta::class,"index"])->name('double.criar');
Route::get('/blaze/double/sequencias',[\App\Http\Controllers\Pages\Games\Roleta::class,"sequencias"])->name('double.sequencias');

Route::post('/ajax/criar-sequencia',[\App\Http\Controllers\Jogos\Blaze\Double\Criar\SequenciaDouble::class,'index'])->name('sequencia.criar');

//////////////////////////////////////////////////////////////////////////////////////////////////////
///  MERCADO PAGO RETURN
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/mp/pgamento/response',[\App\Http\Controllers\MercadoPago\Response::class,'index'])->middleware('auth')->name('mp.response.get');

