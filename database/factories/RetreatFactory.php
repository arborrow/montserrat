<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Retreat::class, function (Faker $faker) {
    return [
        'assistant_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'innkeeper_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});
