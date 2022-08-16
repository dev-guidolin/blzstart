<?php

namespace App\Http\Controllers\Telegram\Actions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Http\Request;

class BotAdicionado extends Controller
{
    protected $methods;
    public function __construct()
    {
        $this->methods = new Methods();
    }

    public function index($request)
    {

        $dono_chat = $request['my_chat_member']['from']['id'];
        $chat_id = $request['my_chat_member']['chat']['id'];

        $existeUser = User::where('telegram_id',$dono_chat)->first();

        if(!$existeUser):
            $this->methods->sairDoGrupo($chat_id);
            $mensagem = "Você adicionou nosso Bot de alertas Blaze em ao grupo {$request['my_chat_member']['chat']['title']}, porém você ainda não é nosso cliente";
            $this->methods->enviarMensagem($mensagem,$dono_chat);
            return response('cliente não encontrado',200);
        endif;

        if(mensalidadeEmDia($existeUser->mensalidade)):
            $mensagem = "Sua mensalidade está em aberto, para adicionar o nosso Bot aos seus grupos de sinais, efetue o pagamento.";
            $this->methods->enviarMensagem($mensagem,$existeUser->telegram_id);
            return response('mensalidade em aberto',200);
        endif;

        $is_admin = $this->methods->infoDoBrupo($chat_id);
        if(!$is_admin):
            $mensagem = "O Bot deverá estar como Admin do grupo para enviar os sinais.";
            $this->methods->enviarMensagem($mensagem,$chat_id);
            return response('o bot deve estar como admin do grupo',200);
        endif;

        try {
            Chats::create([
                'chat_id' => $chat_id,
                'name' => $request['my_chat_member']['chat']['title'],
                'chat_obs' => "",
                'user_id' => $dono_chat,
                'total_membros' => $this->methods->contarMembrosDoGrupo($chat_id)->result,
                'is_admin' => 0
            ]);
            $mensagem = "O Bot foi adicionado ao grupo seu grupo ".$request['my_chat_member']['chat']['title'];
            $this->methods->enviarMensagem($mensagem,$dono_chat);
            return  response('Chat criado com sucess',200);
        }catch (\Exception $e){
            return response($e->getMessage(),200);
        }

    }
}
