<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Methods extends Controller
{
    public function sairDoGrupo($chat_id)
    {
        $url = "https://api.telegram.org/".env("BOT_TOKEN")."/leaveChat?chat_id=".$chat_id;

        $request = Http::get($url);
        return $request->body();
    }
    public function enviarMensagem($mensagem,$chatId)
    {
        $url = "https://api.telegram.org/".env("BOT_TOKEN")."/sendMessage?chat_id=$chatId&text=$mensagem";
        $request = Http::get($url);
        return $request->body();
    }
    public function contarMembrosDoGrupo($chatId)
    {
        $url = "https://api.telegram.org/".env("BOT_TOKEN")."/getChatMembersCount?chat_id=$chatId";
        $request = Http::get($url);
        return json_decode($request->body()) ;
    }
    public function infoDoBrupo($chatId)
    {
        $url = "https://api.telegram.org/".env("BOT_TOKEN")."/getChat?chat_id=$chatId";
        $request = Http::get($url);
        return $request->body();
    }
}
