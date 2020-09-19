<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Room::class, function (Faker $faker) {
    return [
        'location_id' => function () {
            return factory(App\Models\Location::class)->create()->id;
        },
        'floor' =>  $faker->numberBetween($min = 1, $max = 9),
        'name' => $faker->lastName.' Suite',
        'description' => $faker->catchPhrase,
        'notes' => $faker->sentence,
        'access' => $faker->word,
        'type' => $faker->word,
        'occupancy' => $faker->randomDigitNotNull,
        'status' => $faker->word,
    ];
});
