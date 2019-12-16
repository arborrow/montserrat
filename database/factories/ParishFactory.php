<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Parish::class, function (Faker $faker) {
    return [
        'diocese_id' => function () {
            return factory(App\Diocese::class)->create()->id;
        },
    ];
});
