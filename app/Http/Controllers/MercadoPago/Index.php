<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MercadoPago;

class Index extends Controller
{
    public function mp()
    {
        MercadoPago\SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $preference->payment_methods =  [
            "excluded_payment_methods" => [
                ["id" => "ticket"]
            ],
        ];

       /* $preference->back_urls = array(
            "success" => route('mp.response.success'),
            "failure" => route('mp.response.failure'),
            "pending" => route('mp.response.pending')
        );*/

        $preference->back_urls = array(
            "success" => "https://f887-2804-d59-831c-5b00-70c9-37d3-5fc9-119a.sa.ngrok.io/mp/response/success",
            "failure" => "https://f887-2804-d59-831c-5b00-70c9-37d3-5fc9-119a.sa.ngrok.io/mp/response/failure",
            "pending" => "https://f887-2804-d59-831c-5b00-70c9-37d3-5fc9-119a.sa.ngrok.io/mp/response/pending",
        );
        // Params de retorno:
        // payment_id , status, external_reference, merchant_order_id
        // https://www.mercadopago.com.br/developers/pt/docs/checkout-pro/checkout-customization/additional-configuration

        $item = new MercadoPago\Item();
        $item->title = 'Mensalidade';
        $item->quantity = 1;
        $item->unit_price = 75.56;
        $preference->items = array($item);
        $preference->save();

        return $preference;
    }
}
