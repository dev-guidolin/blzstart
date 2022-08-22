<?php

namespace App\Http\Controllers\Pages\Games;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roleta extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $chats = Chats::where('user_id',Auth::user()->id)->get()->toArray() ;

        return view('pages.games.sequencias.roleta',['chats' => $chats]);

    }

    public function sequencias()
    {
        dd('hi');

    }
}
