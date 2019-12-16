<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Phone::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'location_type_id' => function () {
            return factory(App\LocationType::class)->create()->id;
        },
    ];
});
