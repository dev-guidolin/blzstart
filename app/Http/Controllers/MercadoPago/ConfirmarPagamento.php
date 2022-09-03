<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConfirmarPagamento extends Controller
{
    /**
     * @param string $pagamentoId
     * @return PromiseInterface|\Illuminate\Http\Client\Response
     */

    public static function index(string $pagamentoId)
    {
        return Http::withToken(env('MERCADO_PAGO_ACCESS_TOKEN'))->get("https://api.mercadopago.com/v1/payments/$pagamentoId");
    }
}
