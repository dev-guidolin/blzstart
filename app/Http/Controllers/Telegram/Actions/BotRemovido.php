<?php

namespace App\Http\Controllers\Telegram\Actions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Chats;
use App\Models\DoubleSequence;
use App\Models\User;
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
        $chat_id = $request['my_chat_member']['chat']['id'];
        $chat = Chats::where('chat_id',$chat_id)->first();



        if($chat):

            $user = User::find($chat->user_id);
            $sequencias = DoubleSequence::where('user_id',$user->id)->get();

            try {

                foreach ($sequencias as $seq):
                    $xplode = explode(';',$seq->chat_id);
                    if (count($xplode) < 2):
                        DoubleSequence::where('id',$seq->id)->update(['chat_id' => null]);
                    else:
                        $novosChats = implode(';',array_diff($xplode, array($chat_id)));
                        DoubleSequence::where('id',$seq->id)->update(['chat_id' =>$novosChats]);
                    endif;
                endforeach;

                Chats::where('id',$chat->id)->delete();


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
