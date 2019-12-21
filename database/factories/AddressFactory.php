<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'location_type_id' => $faker->numberBetween(1, 5),
        'is_primary' => $faker->boolean,
        'is_billing' => $faker->boolean,
        'street_address' => $faker->streetAddress,
        'street_number' => $faker->randomNumber(),
        'street_number_suffix' => $faker->word,
        'street_number_predirectional' => $faker->word,
        'street_name' => $faker->streetName,
        'street_type' => $faker->streetSuffix,
        'street_number_postdirectional' => $faker->word,
        'street_unit' => $faker->secondaryAddress,
        'supplemental_address_1' => $faker->streetAddress,
        'city' => $faker->city,
        'county_id' => $faker->randomNumber(),
        'state_province_id' => $faker->numberBetween(1000, 1050),
        'postal_code_suffix' => $faker->numberBetween(1000, 9999),
        'postal_code' => $faker->postcode,
        'country_id' => '1228',
        'timezone' => $faker->word,
        'name' => $faker->name,
        'master_id' => $faker->randomNumber(),
        'remember_token' => Str::random(10),
    ];
});
