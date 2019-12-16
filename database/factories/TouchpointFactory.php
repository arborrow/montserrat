<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Touchpoint::class, function (Faker $faker) {
    return [
        'person_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'staff_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});
