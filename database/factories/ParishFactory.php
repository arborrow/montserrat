<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Parish::class, function (Faker $faker) {
  $name = $faker->firstName;
  $parish_name = 'St. ' . $name . ' of ' . $this->faker->city . ' Parish';

    return [
      'contact_type' => config('polanco.contact_type.organization'),
      'subcontact_type' => config('polanco.contact_type.parish'),
      'do_not_email' => $faker->boolean,
      'do_not_phone' => $faker->boolean,
      'do_not_mail' => $faker->boolean,
      'do_not_sms' => $faker->boolean,
      'do_not_trade' => $faker->boolean,
      'is_opt_out' => $faker->boolean,
      'sort_name' => $parish_name,
      'display_name' => $parish_name,
      'legal_name' => $parish_name,
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
      'household_name' => $parish_name,
      'organization_name' => $parish_name,
      'created_date' => $faker->dateTime(),
      'modified_date' => $faker->dateTime(),
      'remember_token' => Str::random(10),
      /* TODO: at the moment let's not deal with pasnors/dioceses and relationships
        'diocese_id' => function () {
            return factory(App\Diocese::class)->create()->id;
        }, */
    ];
});
