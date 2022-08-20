<?php

namespace App\Http\Controllers;

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

        $user = User::find($userId)
            ->with('doubleSequence')
            ->with('chats')
            ->first();


        $totalAcertos = $user->doubleSequence->reduce(function ($acerto,$coluna){
            return $acerto += $coluna->acertos;
        },0);


        $data = [
            'user' => $user,
            'chats' => count($user->chats),
            'telegram' => $user->telegram_token,
            'mensalidade' => $user->mensalidade,
            'totalAcertos' => $totalAcertos,
            'sequencias' => count($user->doubleSequence)
        ];
        return view('welcome',$data);
    }
}
