<?php

namespace App\Http\Controllers\Api\Blaze\Double;

use App\Http\Controllers\Controller;
use App\Models\Double;
use App\Models\DoubleSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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


        if(!$existe_resultado):
            Double::create([
                'id' =>  $lastRecord['id'],
                'color' => $lastRecord['color'],
                'roll' => $lastRecord['roll'],
                'server_seed' => $lastRecord['server_seed'],
            ]);
        endif;

        $resultados = Double::orderBy('created_at','desc')->select('color')->take(100)->get()->toArray();


        $cores = function ($data) {
            return $data['color'];
        };
        $coresStringUltimosCem = array_map($cores, $resultados);
        $coresStringUltimosCem = implode($coresStringUltimosCem);

        $sequencia = DoubleSequence::with('user:id,telegram_id,name')
            ->with('chat')
            ->whereHas('user',function ($q){
                return $q->where('status','ativo')
                    ->where('mensalidade','>=',Carbon::now()->subDays(30))
                    ->where('level','regular')
                    ->where('telegram_id','<>',null);
            })
            ->get();

        dd($sequencia);

        $resultadoArray =[];

        foreach ($sequencia as $string):
            $resultadoPartido = substr($coresStringUltimosCem,0,strlen($string->sequencia));
            if ($resultadoPartido === $string->sequencia):
                $resultadoArray[] = $string->toArray();
            endif;
        endforeach;


        dd($existe_resultado,$lastRecord);
    }
}
