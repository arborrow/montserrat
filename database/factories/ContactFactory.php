<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
  $first_name = $faker->firstName;
  $last_name = $faker->lastName;
  $sort_name = $last_name . ', '. $first_name;
  $display_name = $first_name . ' ' . $last_name;
    return [
        'contact_type' => $faker->numberBetween(1,3),
        'subcontact_type' => $faker->numberBetween(4,8),
        'do_not_email' => $faker->boolean,
        'do_not_phone' => $faker->boolean,
        'do_not_mail' => $faker->boolean,
        'do_not_sms' => $faker->boolean,
        'do_not_trade' => $faker->boolean,
        'is_opt_out' => $faker->boolean,
        'sort_name' => $sort_name,
        'display_name' => $display_name,
        'nick_name' => $faker->firstName,
        'legal_name' => $display_name,
        'image_URL' => $faker->word,
        'preferred_communication_method' => $faker->word,
        'preferred_language' => $faker->locale,
        'preferred_mail_format' => $faker->word,
        'hash' => $faker->word,
        'api_key' => $faker->word,
        'source' => $faker->word,
        'first_name' => $first_name,
        'middle_name' => $faker->firstName,
        'last_name' => $last_name,
        'email_greeting_custom' => $faker->word,
        'email_greeting_display' => $faker->word,
        'postal_greeting_custom' => $faker->word,
        'postal_greeting_display' => $faker->word,
        'addressee_greeting_custom' => $faker->word,
        'addressee_greeting_display' => $faker->word,
        'job_title' => $faker->word,
        'gender_id' => $faker->numberBetween(1,2),
        'birth_date' => $faker->dateTime(),
        'is_deceased' => $faker->boolean,
        'deceased_date' => $faker->dateTime(),
        'household_name' => $faker->name,
        'organization_name' => $faker->company,
        'sic_code' => $faker->word,
        'is_deleted' => $faker->boolean,
        'created_date' => $faker->dateTime(),
        'modified_date' => $faker->dateTime(),
        'remember_token' => Str::random(10),
        'sort_name_count' => $faker->randomNumber(),
    ];
});
