<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
// using Montserrat's number in case of Twilio checks with a random extension
$factory->define(App\Phone::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'location_type_id' => function () {
            return factory(App\LocationType::class)->create()->id;
        },
        'phone' => '9403216020,'.$faker->numberBetween(111,999),
        'phone_type' => $faker->randomElement(['Phone','Fax','Mobile']),
    ];
});
