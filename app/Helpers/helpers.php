<?php

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

    $string = str_replace(0,"⚫",$string);
    $string = str_replace(1,"🔴",$string);
    return str_replace(2,"⚪",$string);

}
