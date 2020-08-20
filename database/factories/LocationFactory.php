<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->lastname.' Hall of '.$faker->city,
        'label' => $faker->word,
        'description' => $faker->sentence,
        'occupancy' => $faker->numberBetween(10, 50),
        'notes' => $faker->text(100),
        'longitude' => $faker->longitude(-93,-103),
        'latitude' => $faker->latitude(30,40),
    ];
});
