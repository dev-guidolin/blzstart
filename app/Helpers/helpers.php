<?php

function mensalidadeEmDia($dataMensalidade)
{
    if( \Carbon\Carbon::parse($dataMensalidade)->diffInDays() < 30):
        return true;
    else:
        return false;
    endif;
}
