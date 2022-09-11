<?php

use App\Http\Controllers\Actions\Sequencias;
use App\Models\Chats;
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

Route::post('delete-sequencia',[Sequencias::class,'delete'])->name('sequencia.delete');
Route::post('edit-sequence',[Sequencias::class,'edit'])->name('sequencia.edit');

Route::get('editar-sequencia/{id}',function ($id){

    return view('pages.games.sequencias.editar_sequencia_double',[
        'sequencia' => \App\Models\DoubleSequence::where('id',$id)->first(),
        'chats' => Chats::where('user_id',Auth::user()->id)->get()->toArray()
    ]);
})->middleware('auth');



Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sequencia/roleta',[\App\Http\Controllers\Pages\Games\Roleta::class,"index"])->name('double.criar');
Route::get('/blaze/double/sequencias',[\App\Http\Controllers\Pages\Games\Roleta::class,"sequencias"])->name('double.sequencias');

Route::post('/ajax/criar-sequencia',[\App\Http\Controllers\Jogos\Blaze\Double\Criar\SequenciaDouble::class,'index'])->name('sequencia.criar');

//////////////////////////////////////////////////////////////////////////////////////////////////////
///  MERCADO PAGO RETURN
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/mp/pgamento/response',[\App\Http\Controllers\MercadoPago\Response::class,'index'])->middleware('auth')->name('mp.response.get');
Route::get('/mp/planos',function (){
    return view('pages.cobrancas.planos',['planos' => \App\Models\Planos::get()]);
})->middleware('auth')->name('mp.planos');

Route::post('mp/assinar-plano',[\App\Http\Controllers\MercadoPago\AssinarPlano::class,'assinar'])->middleware('auth')->name('mp.assinarplano');

