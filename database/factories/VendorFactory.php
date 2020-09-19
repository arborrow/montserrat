<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Vendor::class, function (Faker $faker) {
    $vendor_name = $faker->company;

    return [
        'contact_type' => config('polanco.contact_type.organization'),
        'subcontact_type' => config('polanco.contact_type.vendor'),
        'do_not_email' => $faker->boolean,
        'do_not_phone' => $faker->boolean,
        'do_not_mail' => $faker->boolean,
        'do_not_sms' => $faker->boolean,
        'do_not_trade' => $faker->boolean,
        'is_opt_out' => $faker->boolean,
        'sort_name' => $vendor_name,
        'display_name' => $vendor_name,
        'legal_name' => $vendor_name,
        'image_URL' => $faker->word,
        'preferred_communication_method' => $faker->word,
        'preferred_language' => $faker->locale,
        'preferred_mail_format' => $faker->word,
        'hash' => $faker->word,
        'api_key' => $faker->word,
        'source' => $faker->word,
        'job_title' => $faker->word,
        'birth_date' => $faker->dateTime(),
        'is_deceased' => $faker->boolean,
        'deceased_date' => $faker->dateTime(),
        'household_name' => $vendor_name,
        'organization_name' => $vendor_name,
        'created_date' => $faker->dateTime(),
        'modified_date' => $faker->dateTime(),
        'remember_token' => Str::random(10),
    ];
});
