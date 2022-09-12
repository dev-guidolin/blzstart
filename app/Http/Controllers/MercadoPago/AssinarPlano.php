<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Models\Planos;
use Illuminate\Http\Request;

class AssinarPlano extends Controller
{
    public function assinar(Request $request)
    {
        if(Planos::find($request->id)):

            $mp = new Index();
            $link = $mp->mp($request->id);

            return response()->json([
                'success' => true,
                'message' => $link->init_point
            ]);
        endif;
        return response()->json([
            'success' => false,
            'message' => "Não foi possível gerar o link de pagamento, entre em contato com o suporte."
        ]);

    }
}
