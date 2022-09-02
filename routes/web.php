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


Route::get('/mp/response/success',function (Request $request){
    if(!isset($request->preference_id)):
        return redirect()->to('/login',302);
    endif;

    try {
        \App\Models\Cobranca::where('preference_id',$request->preference_id)->update($request->all());
        return view('pages.cobrancas.pending');
    }catch (Exception $e){
        return view('pages.cobrancas.error');
    }
})->middleware('auth')->name('mp.response.success')->middleware('auth');


Route::get('/mp/pgamento/response',function (Request $request){
    if(!isset($request->preference_id)):
        return redirect()->to('/login',302);
    endif;

    try {
        $dados = \App\Models\Cobranca::where('preference_id',$request->preference_id)->update($request->all());
        return view("pages.cobrancas.".$request->status,['dados' => $dados]);
    }catch (Exception $e){

        return view('pages.cobrancas.error');
    }
})->middleware('auth')->name('mp.response.get');

