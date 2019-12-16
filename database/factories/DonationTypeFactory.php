<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\DonationType::class, function (Faker $faker) {
    return [
        'label' => $faker->word,
        'value' => $faker->word,
        'name' => $faker->name,
        'description' => $faker->text,
        'is_default' => $faker->boolean,
        'is_reserved' => $faker->boolean,
        'is_active' => $faker->boolean,
        'remember_token' => Str::random(10),
    ];
});
