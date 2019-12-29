<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->lastname .' Hall of ' . $faker->city,
        'description' => $faker->sentence,
        'occupancy' => $faker->numberBetween(10, 50),
        'notes' => $faker->text(100),
    ];
});
