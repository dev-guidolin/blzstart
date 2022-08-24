<?php

namespace App\Http\Controllers\Api\Blaze\Double;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Double;
use App\Models\DoubleSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Monolog\Handler\TelegramBotHandler;

class Index extends Controller
{
    public function recebeResultado(Request $request)
    {


        $records = $request->input('records') ?? false;

        if(!$records):
            return response('ok',200);
        endif;

        $lastRecord = reset($records);
        // Achar resultado

        $existe_resultado = Double::find($lastRecord['id']);


        /*if($existe_resultado):
            Double::create([
                //'id' =>  $lastRecord['id'],
                'id' =>  Str::random(10),
                'color' => rand(0,2),
                //'color' => $lastRecord['color'],
                'roll' => $lastRecord['roll'],
                'server_seed' => $lastRecord['server_seed'],
            ]);
        endif;*/


        $resultados = Double::orderBy('created_at','desc')->select('color')->take(100)->get()->toArray();


        $cores = function ($data) {
            return $data['color'];
        };
        $coresStringUltimosCem = array_map($cores, $resultados);
        $coresStringUltimosCem = implode($coresStringUltimosCem);

        $sequencias = DoubleSequence::with('user:id,telegram_id,name')
            ->whereHas('user',function ($q){
                return $q->where('status','ativo')
                    ->where('mensalidade','>=',Carbon::now()->subDays(30))
                    ->where('level','regular')
                    ->where('telegram_id','<>',null);
            })
            ->get()->toArray();


        $resultadoArray =[];
        foreach ($sequencias as $string):

            $resultadoPartida = substr($coresStringUltimosCem,0,strlen($string['sequencia']));

            if ($resultadoPartida === $string['sequencia']):
                $resultadoArray[] = $string;
            endif;

        endforeach;
        //dd($resultadoArray);

        $telegram = new Methods();
        foreach($resultadoArray as $sucess):
            $mensagem = view('telegram.success',[
                'titulo' => $sucess['titulo'],
                'sequencia' => $sucess['sequencia'],
                'descricao' => $sucess['descricao'],
                'entrada' => $sucess['entrada'],
            ])->render();

            $string =
                "<b>🎲 Double - Blaze </b> ".PHP_EOL.
                "<b>💥 ".strtoupper($sucess['titulo'])." 💥</b> ".PHP_EOL.
                "<b>🗯️ ".$sucess['descricao']."</b>".PHP_EOL.PHP_EOL.

                "<b>✅ SPOSTAR EM ✅</b>".PHP_EOL.
                "<b>👉 ".toEmoji($sucess['entrada'])." 👈</b>".PHP_EOL.PHP_EOL.

                '🤖 Bot criado em <a href="http://www.example.com/">telebet.com</a>'.PHP_EOL.
                '🥉 Suporte @turista';
            
                $telegram->enviarMensagemDeAlertaSucesso($string,$sucess['chat_id']);
        endforeach;

        return response()->json([
            'success' => true,
            'message' => 'Mensagens eviadas com sucesso.'
        ]);
    }
}
