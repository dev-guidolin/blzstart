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
