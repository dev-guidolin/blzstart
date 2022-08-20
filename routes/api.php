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

Route::middleware('api')->post('/blaze/double/resultado',[\App\Http\Controllers\Api\Blaze\Double\Index::class,"recebeResultado"]);
