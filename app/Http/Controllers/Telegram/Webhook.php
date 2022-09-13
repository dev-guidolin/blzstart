<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Actions\AtivarCliente;
use App\Http\Controllers\Telegram\Actions\BotAdicionado;
use App\Http\Controllers\Telegram\Actions\BotRemovido;
use App\Http\Controllers\Telegram\Actions\MembroRemovido;
use App\Http\Controllers\Telegram\Actions\NovoMembro;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Webhook extends Controller
{

    public function index($request)
    {
        if (isset($request['message']['new_chat_participant'])):

            $class = new NovoMembro();
            return $class->index($request);

        elseif(isset($request['my_chat_member'])):

            if($request['my_chat_member']['new_chat_member']['status'] == "member"):
                // Bot adicionado a um grupo
                $class = new BotAdicionado();
                return $class->index($request);
            elseif($request['my_chat_member']['new_chat_member']['status'] == "left" or $request['my_chat_member']['new_chat_member']['status'] == "kicked"):
                // Bot removido do grupo
                $class = new BotRemovido();
                return $class->index($request);
            endif;

        elseif (isset($request['message']['chat']['type'])):

            if (isset($request['message']['new_chat_title'])):
                Chats::where('chat_id',$request['message']['chat']['id'])->update([
                    'name' => $request['message']['new_chat_title']
                ]);
                return response('Título do grupo alterado',200);
            elseif (isset($request['message']['text']) and$request['message']['chat']['type'] !== "private" ):
                return response('mensagem do grupo',200);
            elseif(isset($request['message']['new_chat_photo'])):
                return response('Grupo mudou de foto',200);
            endif;

            $class = new AtivarCliente();
            return $class->index($request);

        else:
            return response('apenas resposta',200);
        endif;
    }



}

