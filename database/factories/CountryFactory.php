<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Country::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'iso_code' => $faker->word,
        'country_code' => $faker->word,
        'address_format_id' => $faker->randomNumber(),
        'idd_prefix' => $faker->word,
        'ndd_prefix' => $faker->word,
        'region_id' => $faker->randomNumber(),
        'is_province_abbreviated' => $faker->boolean,
        'remember_token' => Str::random(10),
    ];
});
