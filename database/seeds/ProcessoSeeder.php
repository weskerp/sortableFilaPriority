<?php
use Illuminate\Database\Seeder;
use App\Processo;

class ProcessosSeeder extends Seeder
{
    public function run()
    {
        factory(Processo::class, 10)->create();
    }
}
?>