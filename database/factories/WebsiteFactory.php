<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Website::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'url' => $faker->url,
        'website_type' => $faker->randomElement(['Personal','Work','Main','Facebook','Google','Other','Instagram','LinkedIn','MySpace','Pinterest','SnapChat','Tumblr','Twitter','Vine']),
    ];
});
