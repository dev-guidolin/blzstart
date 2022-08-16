<?php

namespace App\Http\Controllers\Telegram\Actions;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use Illuminate\Http\Request;

class BotRemovido extends Controller
{
    public function index($request)
    {
        $grupo = Chats::where('chat_id',$request['my_chat_member']['chat']['id'])->first();


        if($grupo):
            try {
                Chats::where('chat_id',$request['my_chat_member']['chat']['id'])->delete();
                return  response('chat removido',200);
            }catch (\Exception $e)
            {
                return response($e->getMessage(),200);
            }
        endif;

        return response('grupo não encontrado para ser deletado.',200);
    }
}
