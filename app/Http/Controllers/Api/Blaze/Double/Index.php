<?php

namespace App\Http\Controllers\Api\Blaze\Double;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Telegram\Methods;
use App\Jobs\EnviarAlertaTelegram;
use App\Models\Double;
use App\Models\DoubleSequence;
use DivisionByZeroError;
use Illuminate\Http\Request;
use Illuminate\Queue\Queue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;

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
            return response('ok sem reocors',200);
        endif;

        $lastRecord = reset($records);
        // Achar resultado

        $existe_resultado = Double::find($lastRecord['id']);

        if($existe_resultado):
            return  response()->json([
                'success' => false,
                'message' => "Resultado já está computado no banco de dados."
            ],200);
        endif;



        if(!$existe_resultado):
            Double::create([
                'id' =>  $lastRecord['id'],
                'color' => $lastRecord['color'],
                'roll' => $lastRecord['roll'],
                'server_seed' => $lastRecord['server_seed'],
            ]);
        endif;

        // Busca todos os 100 utimos resultados do banco (já contando com a entrada atual)

        $resultadosCount = Double::get()->count();

        if($resultadosCount >= 150):
            Double::oldest()->take(50)->forceDelete();
        endif;

        $resultados = Double::orderBy('created_at','asc')->select('color')->get()->toArray();

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

        try {

             foreach ($sequencias as $string):
                

                $totalCaracteresResultadoPartida = strlen($string['sequencia']);
                $resultadoPartida = substr($coresStringUltimosCem, -$totalCaracteresResultadoPartida);


                // Envia mensagem com o sinal
                $up = [
                    'aguardar' => DB::raw('aguardar + 1'),
                ];

                DoubleSequence::where('id',$string['id'])->update($up);

                if ($resultadoPartida === $string['sequencia'] and !$string['alerted'] and $string['aguardar'] + 1 >= $totalCaracteresResultadoPartida ):

                    
                    $mensagem = $this->alertaDeEntrada($string);
                    $this->filaEnviarMensagem($mensagem,$string['chat_id']);


                    $up = [
                        'alerted' => 1,
                        'alerted_at' => now()->toDate(),
                        'aguardar' => DB::raw('aguardar + 1'),
                    ];
                    DoubleSequence::where('id',$string['id'])->update($up);
                else:
                    $totalCaracteresResultadoAcertos = strlen($string['entrada']);
                    $resultadoPartidaAcerto = substr($coresStringUltimosCem, -$totalCaracteresResultadoAcertos);

                    // Envia mensagem de sucesso
                    if ($resultadoPartidaAcerto == $string['entrada'] and $string['alerted'] ):

                        $up = [
                            'alerted' => 0,
                            'alerted_at' => now()->toDate(),
                            'acertos' =>  DB::raw('acertos + 1'),
                            'aguardar' =>  0
                        ];
                        DoubleSequence::where('id',$string['id'])->update($up);

                        $mensagem = $this->apostaCerta($string);
                        $this->filaEnviarMensagem($mensagem,$string['chat_id']);

                    endif;

                    if($resultadoPartidaAcerto != $string['entrada'] and $string['alerted'] ):

                        $up = [
                            'alerted' => 0,
                            'alerted_at' => now()->toDate(),
                            'erros' => DB::raw('acertos + 1'),
                            'aguardar' =>  0
                        ];
                        DoubleSequence::where('id',$string['id'])->update($up);

                        $mensagem = $this->apostaErrada($string);
                        $this->filaEnviarMensagem($mensagem,$string['chat_id']);

                    endif;
                endif;

            endforeach;

            return response()->json([
                'success' => true,
                'message' => 'Tudo Certo.'
            ],200);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Erro no processo de enviar mensagens ao Telegram.'
            ]);
        }


    }
    protected function filaEnviarMensagem($mensagem,$chatId)
    {
        $chats = explode(';',$chatId);

        foreach( $chats as $chat):
            EnviarAlertaTelegram::dispatch($mensagem,trim($chat));
        endforeach;
    }

    protected function alertaDeEntrada($success)
    {

        $description = strlen($success['descricao']) > 1 ? "<b>🗯️ ".$success['descricao']."</b>".PHP_EOL.PHP_EOL : "";
        $string =
            "<b>🎲 Double - Blaze </b> ".PHP_EOL.
            "<b>💥 ".strtoupper($success['titulo'])." 💥</b> ".PHP_EOL.PHP_EOL.

            $description.

            "<b>✅ PALPITE EM ✅</b>".PHP_EOL.PHP_EOL.
            "<b>👉 ".toEmoji(substr($success['entrada'],-1))." 👈</b>".PHP_EOL.
            "<b>Assertividade. ".intval(percentualAcerto($success))." %</b>".PHP_EOL.PHP_EOL.

            '🤖 Bot criado em <a href="http://www.example.com/">telebet.com</a>'.PHP_EOL.
            '🥉 Suporte @turista';
        return $string;
    }
    protected function apostaCerta($success)
    {


        $string = "<b>🎲 Double - Blaze </b> ".PHP_EOL.PHP_EOL.
            "<b>✅ PALPITE CERTEIRO ✅</b>".PHP_EOL.PHP_EOL.
            "<b>TOTAL ACERTOS: ".$success['acertos']."</b>".PHP_EOL.PHP_EOL.
            "<b>🕐 ".Carbon::parse($success['alerted_at'])->setTimezone('America/Sao_paulo')->format('d-m-Y H:i:s')."</b>".PHP_EOL.PHP_EOL.
            "<b>Entrada: ".toEmoji(substr($success['entrada'],-1))."</b>".PHP_EOL.
            "<b>Assertividade. ".intval(percentualAcerto($success))." %</b>".PHP_EOL.PHP_EOL.

            '🤖 Bot criado em <a href="http://www.example.com/">telebet.com</a>'.PHP_EOL.
            '🥉 Suporte @turista';

        return $string;

    }
    protected function apostaErrada($success)
    {

        $string = "<b>🎲 Double - Blaze </b> ".PHP_EOL.PHP_EOL.
            "<b>🔴 PALPITE INCORRETO 🔴</b>".PHP_EOL.PHP_EOL.
            "<b>🕐 ".Carbon::parse($success['alerted_at'])->setTimezone('America/Sao_paulo')->format('d-m-Y H:i:s')."</b>".PHP_EOL.PHP_EOL.
            "<b>Entrada: ".toEmoji(substr($success['entrada'],0,1))."</b>".PHP_EOL.
            "<b>Assertivdade. ".intval(percentualAcerto($success))." %</b>".PHP_EOL.PHP_EOL.

            '🤖 Bot criado em <a href="http://www.example.com/">telebet.com</a>'.PHP_EOL.
            '🥉 Suporte @turista';

        return $string;

    }
}
