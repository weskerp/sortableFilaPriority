<?php

use App\Processo;
use Illuminate\Database\Seeder;

class ProcessosSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Processo::class, 10)->create();
    }
}
