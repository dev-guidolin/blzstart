<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\Double;
use App\Models\DoubleSequence;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class Sequencias extends Controller
{
   public function delete(Request $request)
   {
       try {
           DoubleSequence::where('id',$request->id)->delete();
            return response()->json([
                'success' => true,
                'message' => "Sequência apagada."
            ]);
       }catch (ModelNotFoundException $e){
           return response()->json([
               'success' => false,
               'message' => "Erro ao apagar sua sequência, entre em contato com o suporte."
           ]);
       }

   }

   public function edit(Request $request)
   {

       if(!isset($request->seqid)  ):
           return response()->json([
               'success' => false,
               'message' => "Por favor, escolha ao menos um grupo para esta sequência."
           ]);
       endif;

       try {

           if(empty($request->chats)):
               $mensagem = 'Sua sequência não será enviada para nenhum grupo.';
               DoubleSequence::where('id',$request->seqid)->update([
                   'chat_id'    => null,
                   'alerted'    => 0,
                   'aguardar'   => 0
               ]);
           else:
               DoubleSequence::where('id',$request->seqid)->update([
                   'chat_id' =>   implode(';',$request->chats),
               ]);
               $mensagem = 'Sua sequencia foi atualizada com os grupos indicados';
           endif;

           return response()->json([
               'success' => true,
               'message' => $mensagem
           ]);

       }catch (\Exception $e){
           return response()->json([
               'success' => false,
               'message' => "Erro ao salvar novos dados, entre em contato com o suporte." ,$e->getMessage()
           ]);
       }
   }


}
