<?php

namespace App\Http\Controllers\Jogos\Blaze\Double\Criar;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\DoubleSequence;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SequenciaDouble extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $user = User::find(Auth::id());
        $mensalidadeStatus = mensalidadeEmDia($user->mensalidade);
        if(!$mensalidadeStatus):
            return response()->json([
                'success' => false,
                'message' => "Sua mensalidade está atrasada."
            ]);
        endif;

        $validarDados = $this->validarDadosInput($request->all());
        if (!$validarDados['success']):
            return response()->json($validarDados);
        endif;

        $existeSequencia = DoubleSequence::where('user_id',Auth::id())->where('sequencia',$request->seq)->where('entrada',$request->entrada)->first();

        if ($existeSequencia):
            return response()->json([
                'success' => false,
                'message' => "Você já tem uma sequencia idêntica cadastrada"
            ]);
        endif;

        try {

            $grupos ="";
            $lastKey = array_key_last($request->chats);
            foreach($request->chats as $index => $chat):

                if($index == $lastKey):
                    $grupos .= $chat;
                else:
                    $grupos .= "$chat;" ;
                endif;

            endforeach;

            $dataToSave = [
                'user_id' => Auth::id(),
                'chat_id' => $grupos,
                'sequencia' => $request->seq,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao ?? null,
                'entrada' => $request->seq.$request->entrada,
                'acertos' => 0,
                'alerted' => 0,
                'alerted_at' => null,
            ];


            DoubleSequence::create($dataToSave);

            return response()->json([
                'success' => true,
                'message' => "Sequencia criada com sucesso."
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Erro ao criar sequencia, ". $e->getMessage()
            ]);
        }

    }

    private function validarDadosInput(array $dados): array
    {
        if(!isset($dados['seq']) or strlen($dados['seq']) < 1):
            return [
                'success' => false,
                'message' => 'Você deve montar umar sequência.'
            ];
        elseif(!isset($dados['chats']) or empty($dados['chats'])):
            return [
                'success' => false,
                'message' => 'Você deve escolher pelo menos um grupo de alerta.'
            ];
        endif;

        return ['success' => true];
    }
}
