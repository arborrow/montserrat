<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'building_id' => function () {
            return factory(App\Location::class)->create()->id;
        },
    ];
});
