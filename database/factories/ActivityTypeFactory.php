<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ActivityType::class, function (Faker $faker) {
    return [
        'label' => $faker->word,
        'value' => $faker->word,
        'name' => $faker->name,
        'is_active' => $faker->boolean,
        'is_default' => $faker->boolean,
        'weight' => $faker->randomNumber(),
        'remember_token' => Str::random(10),
    ];
});
