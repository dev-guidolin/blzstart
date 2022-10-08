<?php

namespace App\Console\Commands\MercadoPago;

use App\Http\Controllers\MercadoPago\ConfirmarPagamento;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Cobranca;
use App\Models\Planos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AtualizarPagamentos extends Command
{

    protected $signature = 'mp:atualizar';


    protected $description = 'Atualizar todos pagamentos';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $metodos = new Methods();
        $this->alert('Iniciando ciclo de verificação de cobranças.');

        $cobrancas = Cobranca::where('status','pending')->where('collection_id','<>',null)->get();

        if(empty($cobrancas)) : return $this->info("Não há cobranças pendentes."); endif;

        foreach ($cobrancas as $cobranca):

            $this->alert("Atualizando pagamento de ".moneyReal($cobranca['valor']));

            $collection_id = $cobranca['collection_id'];
            $confirmarPagamento = ConfirmarPagamento::index($collection_id);
            $status = $confirmarPagamento->status();


            if($status == 200):
                $response = json_decode($confirmarPagamento->body());

                $planos = Planos::where('valor',$cobranca['valor'])->first();
                $user = User::find($cobranca['user_id']);
                $data = $user->mensalidade;

                Cobranca::where("id",$cobranca['id'])->update([
                    'status'            => $response->status,
                    'collection_status' => $response->status,
                ]);

                if($response->status == "approved"):
                    User::where('id',$cobranca['user_id'])->update([
                        'mensalidade' => Carbon::parse($data)->addMonth($planos->validade)->format('Y-m-d H:i:s')
                    ]);
                    $mensagem ="🤩 O pagamento de ".$cobranca['valor']." foi aprovado.";
                    $metodos->enviarMensagem($mensagem, env('thiago_telegrgam_id'));
                endif;
                $this->info("Cobrança atualizada");
            else:
                $this->warn("Erro na cobrança ".$cobranca['collection_id']);
                $mensagem = "🚨 Erro na cobrança ".$cobranca['collection_id'];
                $metodos->enviarMensagem($mensagem, env('thiago_telegrgam_id'));
            endif;
        endforeach;

        return $this->info('Cobranças atualizadas.');

    }
}
