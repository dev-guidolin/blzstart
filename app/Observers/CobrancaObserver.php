<?php

namespace App\Observers;

use App\Models\Cobranca;

class CobrancaObserver
{
    /**
     * Handle the cobranca "created" event.
     *
     * @param Cobranca $cobranca
     * @return void
     */
    public function created(Cobranca $cobranca)
    {
        $menesagem = "💥 Cobrança no valor de R$ ". moneyReal($cobranca->valor)." gerada.";
        alertaProprietarioTelegram($menesagem);
    }

    /**
     * Handle the cobranca "updated" event.
     *
     * @param Cobranca $cobranca
     * @return void
     */
    public function updated(Cobranca $cobranca)
    {
        $menesagem = "🚨🚨 Cobrança no valor de R$ ". moneyReal($cobranca->valor)." atualizada para o status: ".$cobranca->status.PHP_EOL." Plano: ". $cobranca->plano;

        alertaProprietarioTelegram($menesagem);
    }

    /**
     * Handle the cobranca "deleted" event.
     *
     * @param Cobranca $cobranca
     * @return void
     */
    public function deleted(cobranca $cobranca)
    {
        //
    }

    /**
     * Handle the cobranca "restored" event.
     *
     * @param Cobranca $cobranca
     * @return void
     */
    public function restored(cobranca $cobranca)
    {
        //
    }

    /**
     * Handle the cobranca "force deleted" event.
     *
     * @param Cobranca $cobranca
     * @return void
     */
    public function forceDeleted(cobranca $cobranca)
    {
        //
    }
}
