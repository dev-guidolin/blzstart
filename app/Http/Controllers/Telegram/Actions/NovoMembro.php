<?php

namespace App\Http\Controllers\Telegram\Actions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Membros;
use Illuminate\Http\Request;

class NovoMembro extends Controller
{
    protected $methods;
    public function __construct()
    {
        $this->methods = new Methods();
    }

    public function index($request)
    {

        $participanteId = $request['message']['new_chat_participant'];

        if($participanteId['id'] != env("BOT_CHAT_ID") And !Membros::where('membro_id',$request['message']['new_chat_participant']['id'])->first()):
            Membros::create([
                'membro_id' => $participanteId['id'],
                'is_bot' => $participanteId['is_bot'],
                'nome' => $participanteId['first_name'],
                'user_name' => $participanteId['username']
            ]);
            $this->methods->enviarMensagem('o usuário tal, entreou no grupo talb.',$participanteId['id']);
            return respose('membro salvo com sucesso',200);
        endif;

        return response('participante não encontrado ou é o próprio bot',200);

    }
}
