<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Roomstate::class, function (Faker $faker) {
    return [
        'room_id' => function () {
            return factory(App\Room::class)->create()->id;
        },
    ];
});
