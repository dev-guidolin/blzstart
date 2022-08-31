<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebHook extends Controller
{
    public function success(Request $request)
    {
        return response($request->all());
    }
    public function pending(Request $request)
    {
        return response($request->all());
    }
    public function failure(Request $request)
    {

        return response($request->all());
    }
}
