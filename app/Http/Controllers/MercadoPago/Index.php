<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Models\Cobranca;
use App\Models\Planos;
use Illuminate\Http\Request;
use MercadoPago;

class Index extends Controller
{
    public function mp($planoId)
    {
        MercadoPago\SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        $preference = new MercadoPago\Preference();

        $preference->payment_methods =  [
            "excluded_payment_methods" => [
                ["id" => "ticket"]
            ],
        ];
        $preference->auto_return = "approved";

        $preference->back_urls = array(
            "success" =>    route('mp.response.get'),
            "failure" =>    route('mp.response.get'),
            "pending" =>    route('mp.response.get'),
        );

        $planos = Planos::whereId($planoId)->first();
        // Params de retorno:
        // payment_id , status, external_reference, merchant_order_id
        // https://www.mercadopago.com.br/developers/pt/docs/checkout-pro/checkout-customization/additional-configuration

        $item = new MercadoPago\Item();
        $item->title = strtoupper($planos->nome) . " - Bot Sinais";
        $item->quantity = 1;
        $item->unit_price = $planos->valor;
        $preference->items = array($item);
        $preference->save();

        try {
            $array = [
                'user_id' => auth()->id(),
                'valor' => $planos->valor,
                'plano' => $item->title,
                'preference_id' => $preference->id,
                'validade_plano' => now()->addMonths($planos->validade)
            ];
            Cobranca::create($array);
        }catch (\Exception $e){
            return "Erro ao gerar link de pagamento, entre em contato com o suporte.";
        }



        return $preference;
    }
}
