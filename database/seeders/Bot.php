<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Bot extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Bot::create([
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'name' => 'Pepe Legal',
            'obs' => ''
        ]);
    }
}
