<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Reservation::class, function (Faker $faker) {
    return [
        'registration_id' => function () {
            return factory(App\Registration::class)->create()->id;
        },
        'room_id' => function () {
            return factory(App\Room::class)->create()->id;
        },
    ];
});
