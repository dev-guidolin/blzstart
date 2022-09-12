<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Planos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planos = [
            ['nome' => 'mensal','validade' => 1,'valor' => 149.99],
            ['nome' => 'trimestral','validade' => 3,'valor' => 349.99],
            ['nome' => 'semestral','validade' => 6,'valor' => 549.99],
        ];

        \App\Models\Planos::truncate();
        foreach ($planos as $plano):
            \App\Models\Planos::create($plano);
        endforeach;
    }
}
