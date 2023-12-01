<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cod');
            $table->string('name');
            $table->integer('prox')->nullable();
            $table->integer('ant')->nullable();
            $table->timestamps();
        });

        // Insert default values
        DB::table('processos')->insert([
            ['cod' => 1, 'name' => 'café da manhã', 'prox' => 2, 'ant' => null],
            ['cod' => 2, 'name' => 'lanche da manhã', 'prox' => 3, 'ant' => 1],
            ['cod' => 3, 'name' => 'Almoço', 'prox' => 4, 'ant' => 2],
            ['cod' => 4, 'name' => 'Lanche da tarde', 'prox' => 5, 'ant' => 3],
            ['cod' => 5, 'name' => 'Jantar', 'prox' => 6, 'ant' => 4],
            ['cod' => 6, 'name' => 'Lanche da noite', 'prox' => 7, 'ant' => 5],
            ['cod' => 7, 'name' => 'Lanche da meia noite', 'prox' => null, 'ant' => 6],
        ]);
    }
    public function down()
    {
        Schema::dropIfExists('processos');
    }
}
