<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Methods extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = "https://api.telegram.org/bot".env("TELEGRAM_BOT_TOKEN");
    }

    public function sairDoGrupo($chat_id)
    {
        $url = $this->baseUrl."/leaveChat?chat_id=".$chat_id;

        $request = Http::get($url);
        return $request->body();
    }
    public function enviarMensagem($mensagem,$chatId)
    {
        $url = $this->baseUrl."/sendMessage?chat_id=$chatId&parse_mode=html&text=$mensagem";

        $request = Http::get($url);
        return $request->body();
    }

    public function contarMembrosDoGrupo($chatId)
    {
        $url = $this->baseUrl."/getChatMembersCount?chat_id=$chatId";
        $request = Http::get($url);
        return json_decode($request->body()) ;
    }
    public function infoDoBrupo($chatId)
    {
        $url = $this->baseUrl."/getChat?chat_id=$chatId";
        $request = Http::get($url);
        return $request->body();
    }
}
