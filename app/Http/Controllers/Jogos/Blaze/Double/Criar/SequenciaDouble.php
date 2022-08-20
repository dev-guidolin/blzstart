<?php

namespace App\Http\Controllers\Jogos\Blaze\Double\Criar;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\DoubleSequence;
use App\Models\User;
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
                'message' => "Sua mensalidade está em aberto."
            ]);
        endif;

        $existeSequencia = DoubleSequence::where('user_id',Auth::id())->where('sequencia',$request->seq)->where('entrada',$request->entrada)->first();

        if ($existeSequencia):
            return response()->json([
                'success' => false,
                'message' => "Você já tem uma sequencia idêntica cadastrada"
            ]);
        endif;

        $existeChat = Chats::find($user->telegram_id);
        if($existeChat):
            return response()->json([
                'success' => false,
                'message' => 'Você precisa cadastrar um grupo para receber os sinais.'
            ]);
        endif;

        $dataToSave = [
            'user_id' => Auth::id(),
            'chat_id' => $user->telegram_id,
            'sequencia' => $request->seq,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao ?? null,
            'lenght' => strlen($request->seq),
            'entrada' => $request->entrada,
            'acertos' => 0
        ];

        try {
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
}
