<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\ActivityContact::class, function (Faker $faker) {
    return [
        'activity_id' => $faker->randomNumber(),
        'contact_id' => $faker->randomNumber(),
        'record_type_id' => $faker->randomNumber(),
        'remember_token' => Str::random(10),
    ];
});
