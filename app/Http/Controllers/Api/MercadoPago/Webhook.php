<?php

namespace App\Http\Controllers\Api\MercadoPago;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Webhook extends Controller
{
    public function index(Request $request)
    {
       return response('teste',200);

    }
}
