<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MercadoPago\Index;
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
        $mp = new Index();
        $teste = $mp->mp();

        $totalAcertos = $user->doubleSequence->reduce(function ($acerto,$coluna){
            return $acerto += $coluna->acertos;
        },0);


        $data = [
            'user' => $user,
            'chats' => count($user->chats),
            'telegram' => $user->telegram_token,
            'mensalidade' => $user->mensalidade,
            'totalAcertos' => $totalAcertos,
            'sequencias' => count($user->doubleSequence),
            'mp_id' => $teste->id
        ];

        return view('home_admin',$data);
    }
}
