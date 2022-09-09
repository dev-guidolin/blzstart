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

        // Aqui renderiza pagina inicial do admin

        $userId = Auth::user()->getAuthIdentifier();
        $user = User::whereId($userId)
            ->with('doubleSequence')
            ->with('chats')
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
        //dd($sequencias);


        //$teste = new GerarLinkCobranca();
        //$link =  $teste->index(1);



        $data = [
            'user' => $user,
            'chats' => count($user->chats),
            'telegram' => $user->telegram_token,
            'mensalidade' => $user->mensalidade,
            'totalAcertos' => $totalAcertos,
            'sequencias' => count($user->doubleSequence),
            'mp_id' => '',
            'mp_initPoint' => '',
            'sequencias' => $sequencias,


        ];


        return view('home_admin',$data);
    }
}
