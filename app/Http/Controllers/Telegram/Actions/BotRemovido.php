<?php

namespace App\Http\Controllers\Telegram\Actions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Chats;
use Illuminate\Http\Request;

class BotRemovido extends Controller
{
    protected $methods;
    public function __construct()
    {
        $this->methods = new Methods();
    }

    public function index($request)
    {
        $grupo = Chats::where('chat_id',$request['my_chat_member']['chat']['id'])->first();

        if($grupo):
            try {
                Chats::where('chat_id',$request['my_chat_member']['chat']['id'])->delete();

                $mensagem = "O ".$request['my_chat_member']['from']['username'] . " removeu nosso BOT do grupo ".$request['my_chat_member']['chat']['title'].".";

                $this->methods->enviarMensagem($mensagem,$request['my_chat_member']['from']['id']);
                return  response('chat removido',200);
            }catch (\Exception $e)
            {
                return response($e->getMessage(),200);
            }
        endif;

        return response('grupo não encontrado para ser deletado.',200);
    }
}
