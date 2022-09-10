<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Telegram\Webhook;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('/telegram/webhook',function (Request $request){

    if (isset($request['message']['from']['is_bot']) and $request['message']['from']['is_bot']):
        return response('proibido_bot',200);
    endif;

    $webHooks = new Webhook();
    return $webHooks->index($request);

});

////////////////////////// Pages Internas

Route::middleware('api')->post('/blaze/double/resultado',[\App\Http\Controllers\Api\Blaze\Double\Index::class,"recebeResultado"]);
/**
 * MERCADO PAGO
 */

Route::middleware('api')->post('/mp/response/success',[\App\Http\Controllers\MercadoPago\WebHook::class,'success'])->name('mp.response.success.post');
Route::middleware('api')->post('/mp/response/pending',[\App\Http\Controllers\MercadoPago\WebHook::class,'pending'])->name('mp.response.pending.post');
Route::middleware('api')->post('/mp/response/failure',[\App\Http\Controllers\MercadoPago\WebHook::class,'failure'])->name('mp.response.failure.post');
