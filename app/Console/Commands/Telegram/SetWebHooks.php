<?php

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetWebHooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:hook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seta url para webhook do Telegram';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = "https://api.telegram.org/bot".env("TELEGRAM_BOT_TOKEN")."/setWebhook?url=".env("TELEGRAM_WEBHOOK")."/api/telegram/webhook";
        $setando = Http::get($url);
        $resposta = json_decode($setando->body($url));

        return $this->alert($resposta->description." : ".$url);

    }
}
