<?php

use App\Http\Controllers\Telegram\Methods;
use Psy\Exception\ErrorException;

function mensalidadeEmDia($dataMensalidade)
{
    $dataPagamento = \Carbon\Carbon::parse($dataMensalidade);
    $dataAgora = \Carbon\Carbon::now();

    if( $dataAgora->diffInDays($dataPagamento) < 30):
        return true;
    else:
        return false;
    endif;
}

function toEmoji($string)
{

    $string = str_replace(2,"⚫",$string);
    $string = str_replace(1,"🔴",$string);
    return str_replace(0,"⚪",$string);

}

function percentualAcerto($success){

    try {
        return $success['acertos']/($success['acertos'] + $success['erros']) * 100;
    }catch (DivisionByZeroError $e){
        return 0;
    }catch (ErrorException $e){
        return 0;
    }
}
function show_array($data, $exit = true)
{

    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}

function moneyReal($valor)
{
    $retorno = number_format($valor, 2, ",", ".");

    return $retorno;
}
function alertaProprietarioTelegram($mensagem){

    $telegram = new Methods();
    $telegram->enviarMensagem($mensagem,env('thiago_telegrgam_id'));
}
