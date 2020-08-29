<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    $name = $faker->lastname . ' of ' . $faker->city;
    return [
        'name' => $name,
        'description' => $faker->sentence,
        'occupancy' => $faker->numberBetween(10, 50),
        'notes' => $faker->text(100),
        'label' => $name,
        'longitude' => $faker->longitude(-93,-103),
        'latitude' => $faker->latitude(30,40),
        'type' =>  $faker->randomElement(config('polanco.locations_type')),
    ];
});
