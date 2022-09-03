<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Models\Cobranca;
use App\Models\User;
use Illuminate\Http\Request;

class Response extends Controller
{
    public function index(Request $request)
    {
        if(!isset($request->collection_id)):
            return redirect()->to('/login',302);
        endif;

        $dadosCobranca =Cobranca::where('preference_id',$request->preference_id)->first();

        $consultarPagamento = ConfirmarPagamento::index($request->collection_id);

        $body = json_decode($consultarPagamento->body());

        if($body->status !== $request->status or !$dadosCobranca):
            return view('pages.cobrancas.error');
        endif;

        try {
            $update = $request->all();
            $update['status'] = $body->status;
            $dados = \App\Models\Cobranca::where('preference_id',$request->preference_id)->update($update);

            if(!$dados):
                return view('pages.cobrancas.error');
            endif;

            User::find($dadosCobranca->user_id)->update([
                'mensalidade' => $dadosCobranca->validade_plano
            ]);

            return view("pages.cobrancas.".$request->status,['dados' => $dados]);
        }catch (Exception $e){

            return view('pages.cobrancas.error');
        }
    }
}
