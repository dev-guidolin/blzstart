<?php

namespace App\Http\Controllers\Jogos\Blaze\Crash\Resultados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class index extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => $request
        ]);
    }
}
