<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Registration::class, function (Faker $faker) {
    return [
        'event_id' => function () {
            return factory(App\Retreat::class)->create()->id;
        },
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});
