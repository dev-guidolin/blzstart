<?php

namespace App\Observers;

use App\Models\cobranca;

class CobrancaObserver
{
    /**
     * Handle the cobranca "created" event.
     *
     * @param  \App\Models\cobranca  $cobranca
     * @return void
     */
    public function created(cobranca $cobranca)
    {
        $menesagem = "💥 Cobrança no valor de R$ ". moneyReal($cobranca->valor)." gerada.";
        alertaProprietarioTelegram($menesagem);
    }

    /**
     * Handle the cobranca "updated" event.
     *
     * @param  \App\Models\cobranca  $cobranca
     * @return void
     */
    public function updated(cobranca $cobranca)
    {
        $menesagem = "🚨🚨 Cobrança no valor de R$ ". moneyReal($cobranca->valor)." atualizada para o status: ".$cobranca->status.PHP_EOL." Plano: ". $cobranca->plano;
        alertaProprietarioTelegram($menesagem);
    }

    /**
     * Handle the cobranca "deleted" event.
     *
     * @param  \App\Models\cobranca  $cobranca
     * @return void
     */
    public function deleted(cobranca $cobranca)
    {
        //
    }

    /**
     * Handle the cobranca "restored" event.
     *
     * @param  \App\Models\cobranca  $cobranca
     * @return void
     */
    public function restored(cobranca $cobranca)
    {
        //
    }

    /**
     * Handle the cobranca "force deleted" event.
     *
     * @param  \App\Models\cobranca  $cobranca
     * @return void
     */
    public function forceDeleted(cobranca $cobranca)
    {
        //
    }
}
