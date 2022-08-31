<?php

namespace App\Http\Controllers\Pages\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MercadoPago\Index;
use App\Models\DoubleSequence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function start()
    {



        $userId = Auth::user()->getAuthIdentifier();

        $user = User::find($userId)
            ->with('doubleSequence')
            ->with('telegram')
            ->with('whatsapp')
            ->first();
        $ultimasSequencias = DoubleSequence::take(100)->get();

        return view('dashboard',['user' => $user,'ultimasSequencias' => $ultimasSequencias]);

    }
}
