<?php

namespace App\Jobs;

use App\Http\Controllers\Telegram\Methods;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarAlertaTelegram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $chatId;
    private $mensagem;
    public function __construct(string $mensagem, string $chatId)
    {
        $this->mensagem = $mensagem;
        $this->chatId = $chatId;
    }

    public function handle()
    {
        $telegram = new Methods();
        $telegram->enviarMensagem($this->mensagem,$this->chatId);
    }
}
