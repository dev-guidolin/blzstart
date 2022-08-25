<?php

namespace App\Http\Controllers\Api\Blaze\Double;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Models\Double;
use App\Models\DoubleSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Monolog\Handler\TelegramBotHandler;

class Index extends Controller
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Methods();
    }

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
        $idsAcertos =[];
        $ArrayAcertos = [];
        foreach ($sequencias as $string):

            $resultadoPartida = substr($coresStringUltimosCem,0,strlen($string['sequencia']));
            $resultadoPartidaAcerto = substr($coresStringUltimosCem,0,strlen($string['sequencia'])+1);

            if ($resultadoPartidaAcerto === $string['entrada']):
                $idsAcertos[] = $string['id'];
                $ArrayAcertos[] = $string;
            endif;

            if ($resultadoPartida === $string['sequencia']):
                $resultadoArray[] = $string;
            endif;

        endforeach;

        DoubleSequence::whereIn('id',$idsAcertos)->increment('acertos',1);

        if (!empty($resultadoArray)):
            $this->alertaAposta($resultadoArray);
        endif;


        if (!empty($ArrayAcertos)):
            $this->alertaSucessoAcerto($ArrayAcertos);
        endif;

        return response()->json([
            'success' => true,
            'message' => 'Mensagens eviadas com sucesso.'
        ]);
    }
    protected function alertaAposta($resultadoArray)
    {
        foreach($resultadoArray as $sucess):

            $description = strlen($sucess['descricao']) > 1 ? "<b>🗯️ ".$sucess['descricao']."</b>".PHP_EOL.PHP_EOL : "";
            $string =
                "<b>🎲 Double - Blaze </b> ".PHP_EOL.
                "<b>💥 ".strtoupper($sucess['titulo'])." 💥</b> ".PHP_EOL.

                $description.

                "<b>✅ APOSTAR EM ✅</b>".PHP_EOL.
                "<b>👉 ".toEmoji(substr($sucess['entrada'],0,1))." 👈</b>".PHP_EOL.PHP_EOL.

                '🤖 Bot criado em <a href="http://www.example.com/">telebet.com</a>'.PHP_EOL.
                '🥉 Suporte @turista';

            $this->telegram->enviarMensagemDeAlertaSucesso($string,$sucess['chat_id']);
        endforeach;

        return true;

    }
    protected function alertaSucessoAcerto($resultadoArrayAcerto)
    {
        foreach($resultadoArrayAcerto as $sucess):

            $string =
                "<b>🎲 Double - Blaze </b> ".PHP_EOL.PHP_EOL.
                "<b>✅ APOSTA CERTEIRA ✅</b>".PHP_EOL.PHP_EOL.
                "<b> 🕐 ".\Carbon\Carbon::parse($sucess['created_at'])->format('d-m-Y H:i:s')."</b>".PHP_EOL.PHP_EOL.
                "<b> Entrada: ".toEmoji(substr($sucess['entrada'],0,1))."</b>".PHP_EOL.PHP_EOL.

                '🤖 Bot criado em <a href="http://www.example.com/">telebet.com</a>'.PHP_EOL.
                '🥉 Suporte @turista';

            $this->telegram->enviarMensagemDeAlertaSucesso($string,$sucess['chat_id']);
        endforeach;
        return true;

    }
}
