<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MercadoPago\GerarLinkCobranca;
use App\Models\Chats;
use App\Models\DoubleSequence;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() : Renderable
    {

        $userId = Auth::user()->getAuthIdentifier();
        $user = User::whereId($userId)
            ->with('doubleSequence')
            ->with('chats')
            ->with('plano')
            ->first();


        $totalAcertos = $user->doubleSequence->reduce(function ($acerto,$coluna){
            return $acerto += $coluna->acertos;
        },0);

        $sequencias = [];
        foreach ($user->doubleSequence as $seq):
            $sequencias[$seq->id] = [
                'data'=>$seq,
                'grupos'=>Chats::whereIn('chat_id',explode(';',$seq->chat_id))
                    ->select('name')
                    ->get()
                    ->map(function($name){  return $name->name;})
            ];
        endforeach;


        $data = [
            'user'          => $user,
            'chats'         => count($user->chats),
            'telegram'      => $user->telegram_token,
            'mensalidade'   => $user->mensalidade,
            'sequencias'    => $sequencias,
            'acertos'       => $totalAcertos

        ];


        return view('home_admin',$data);
    }
}
