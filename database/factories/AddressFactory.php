<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'location_type_id' => $faker->randomNumber(),
        'is_primary' => $faker->randomNumber(),
        'is_billing' => $faker->randomNumber(),
        'street_address' => $faker->word,
        'street_number' => $faker->randomNumber(),
        'street_number_suffix' => $faker->word,
        'street_number_predirectional' => $faker->word,
        'street_name' => $faker->word,
        'street_type' => $faker->word,
        'street_number_postdirectional' => $faker->word,
        'street_unit' => $faker->word,
        'supplemental_address_1' => $faker->word,
        'supplemental_address_2' => $faker->word,
        'supplemental_address_3' => $faker->word,
        'city' => $faker->city,
        'county_id' => $faker->randomNumber(),
        'state_province_id' => $faker->randomNumber(),
        'postal_code_suffix' => $faker->word,
        'postal_code' => $faker->postcode,
        'usps_adc' => $faker->word,
        'country_id' => $faker->randomNumber(),
        'geo_code_1' => $faker->randomFloat(),
        'geo_code_2' => $faker->randomFloat(),
        'manual_geo_code' => $faker->randomNumber(),
        'timezone' => $faker->word,
        'name' => $faker->name,
        'master_id' => $faker->randomNumber(),
        'remember_token' => Str::random(10),
    ];
});
