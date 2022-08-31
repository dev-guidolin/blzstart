<?php

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
Route::get('/mp/response/success',[\App\Http\Controllers\MercadoPago\WebHook::class,'success'])->name('mp.response.success')->middleware('auth');
Route::get('/mp/response/pending',[\App\Http\Controllers\MercadoPago\WebHook::class,'pending'])->name('mp.response.pending')->middleware('auth');
Route::get('/mp/response/failure',[\App\Http\Controllers\MercadoPago\WebHook::class,'failure'])->name('mp.response.failure')->middleware('auth');


