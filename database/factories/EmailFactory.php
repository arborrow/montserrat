<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Email::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Models\Contact::class)->create()->id;
        },
        'location_type_id' => function () {
            return factory(App\Models\LocationType::class)->create()->id;
        },
        'email' => $faker->safeEmail,
        'is_primary' => $faker->boolean,
        'is_billing' => $faker->boolean,
        'on_hold' => $faker->boolean,
        'is_bulkmail' => $faker->boolean,
        'hold_date' => $faker->date(),
        'reset_date' => $faker->date(),
        'signature_text' => $faker->text,
        'signature_html' => $faker->text,
        'remember_token' => Str::random(10),
    ];
});
