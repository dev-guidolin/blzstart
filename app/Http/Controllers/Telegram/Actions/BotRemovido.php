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
        $chat = Chats::where('chat_id',$request['my_chat_member']['chat']['id'])->first();

        if($chat):

            $user = User::find($chat->user_id);

            $seq = DoubleSequence::whereIn('chat_id',[$chat->id])->update([
                'chat_id' => $user->telegram_id
            ]);

            dd($seq);

            try {


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
