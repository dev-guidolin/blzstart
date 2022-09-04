<?php

namespace App\Http\Controllers\Telegram\Actions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\User;
use Illuminate\Http\Request;

class AtivarCliente extends Controller
{
    protected $methods;
    public function __construct()
    {
        $this->methods = new Methods();
    }
    public function index($request)
    {
        $chatId =  $request['message']['from']['id'];
        $telegramToken = $request['message']['text'];


        // Verifica se cliente já está cadastrado
        $cliente =  User::where('telegram_id',$chatId)->first();


        if ($cliente AND $cliente->telegram_id !=null):
            $this->methods->enviarMensagem("Oi {$request['message']['from']['username']}, sua conta já está cadastrada",$chatId);
            return response('Conta já cadastrada',200);
        endif;

        // Verifica se a mensagem é um token e pertence a algum cliente
        $existeUser = User::where('telegram_token',strtoupper($telegramToken))->first();


        if( !$existeUser or strlen($existeUser->telegram_token) !== 4 ):

            $mensagem = "Por favor, digite o Token do Telegram composto por 4 Dígitos que se encontra em sua área administrativa.";
            $this->methods->enviarMensagem($mensagem,$chatId);
            return response('cliente não cadastrado',200);

        elseif ($existeUser->telegram_id == null):
            // Atualiza usuário
            $existeUser->update([
                'telegram_id' => $chatId,
            ]);
            $mensagem = "Sua conta voi validada, você já pode começar a criar suas sequências de alertas.";
            $this->methods->enviarMensagem($mensagem,$chatId);
            return response('conta validada',200);
        else:
            $mensagem = "Sua conta já voi verificada, você já pode criar grupos e enviar suas sequências.";
            $this->methods->enviarMensagem($mensagem,$chatId);
            return response('conta verificada',200);
        endif;

    }
}
