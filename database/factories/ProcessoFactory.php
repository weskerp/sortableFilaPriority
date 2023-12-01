<?php
use Faker\Generator as Faker;

$factory->define(App\Processo::class, function (Faker $faker) {
    return [
        'cod' => $faker->randomNumber(5),
        'nome' => $faker->word,
        'prox' => $faker->randomNumber(),
        'ant' => $faker->randomNumber(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

