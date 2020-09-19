<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Roomstate::class, function (Faker $faker) {
    return [
        'room_id' => function () {
            return factory(App\Models\Room::class)->create()->id;
        },
    ];
});
