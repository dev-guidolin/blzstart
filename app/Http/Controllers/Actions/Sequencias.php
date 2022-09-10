<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\DoubleSequence;
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
}
