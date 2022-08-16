<?php

namespace App\Http\Controllers\Jogos\Blaze\Double\Resultados;

use App\Http\Controllers\Controller;
use App\Models\DoubleSequence;
use App\Models\Jogos\Blaze\Roleta;
use App\Models\Jogos\Blaze\Sequencia;
use Illuminate\Http\Request;


class index extends Controller
{
    public function index(Request $request)
    {

        $resultado_id = $request->input('id');

        if (!Roleta::find($resultado_id)):

            //Double::create($request->input());

            $resultados = Roleta::orderBy('created_at','desc')->select('color')->take(100)->get()->toArray();


            $cores = function ($data) {
                return $data['color'];
            };


            $sequencia = DoubleSequence::with('user:id,telegram_id,name')
            ->with('telegraph_chat')
            ->whereHas('user',function ($q){
                return $q->where('status','ativo')
                    ->where('mensalidade',true)
                    ->where('status','ativo')
                    ->where('level','regular')
                    ->where('telegram_id','<>',null);
            })
            ->select('sequencia','titulo','descricao','lenght','user_id','entrada','id')
            ->where('jogo_id',env("BLAZE_ROLETA_ID"))
            ->get();
            dd($sequencia);



            $coresStringUltimosCem = array_map($cores, $resultados);
            $coresStringUltimosCem = implode($coresStringUltimosCem);

            $resultadoArray =[];

            foreach ($sequencia as $string):
                $resultadoPartido = substr($coresStringUltimosCem,0,strlen($string->sequencia));
                if ($resultadoPartido === $string->sequencia):
                    $resultadoArray[] = $string->toArray();
                endif;
            endforeach;



            if (!empty($resultadoArray)):
                foreach ($resultadoArray as $resultadoUser):
                    foreach ($resultadoUser['telegram'] as $enviarAlerta):

                    $mensagem = $resultadoUser['titulo'] .   $resultadoUser['descricao'];

                    $chat = TelegraphChat::find(3);
                    $chat->message($mensagem)->send();

                    endforeach;

                endforeach;
            endif;


            return response()->json([
                'success' => true,
                'message' => $resultadoArray
            ],200);
        else:
            return response()->json([
                'success' => false,
                'message' => "Resultado igual..."
            ],200);
        endif;
    }
}
