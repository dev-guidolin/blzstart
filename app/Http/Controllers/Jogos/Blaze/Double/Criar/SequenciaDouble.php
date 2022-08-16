<?php

namespace App\Http\Controllers\Jogos\Blaze\Double\Criar;

use App\Http\Controllers\Controller;
use App\Models\DoubleSequence;
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

        $existeSequencia = DoubleSequence::where('user_id',Auth::id())->where('sequencia',$request->seq)->where('entrada',$request->entrada)->first();

        if ($existeSequencia):
            return response()->json([
                'success' => false,
                'message' => "Você já tem uma sequencia idêntica cadastrada"
            ]);
        endif;


        $dataToSave = [
            'user_id' => Auth::id(),
            'chat_id' => null,
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
