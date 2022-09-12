<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Novouser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => 'thiago',
            'email'             => 'thiago@teste.com',
            'email_verified_at' => null,
            'mensalidade'       => now(),
            'plano_id'          => null,
            'password'          => Hash::make('bundamole'),
            'status'            => 'ativo',
            'level'             => 'regular',
            'telegram_id'       => Str::random(4),
            'whatsapp_id'       => Str::random(4),
            'whatsapp_token'    => Str::random(4),
            'telegram_token'    => Str::random(4),
            'phone'             => null,
            'remember_token'    => Str::random(10),
        ]);
    }
}
