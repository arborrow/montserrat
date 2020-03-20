<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\RelationshipType::class, function (Faker $faker) {
    return [
      'name_a_b' => $faker->company,
      'name_b_a' => $faker->jobTitle,
      'label_a_b' => 'has a '.$faker->word.' of ',
      'label_b_a' => $faker->word.' for ',
      'description' => $faker->catchPhrase,
      'contact_type_a' => array_rand(['Individual', 'Organization', 'Household']),
      'contact_type_b' => array_rand(['Individual', 'Organization', 'Household']),
      'contact_sub_type_a' => null,
      'contact_sub_type_b' => null,
      'is_reserved' => null,
      'is_active' => 1,
      'created_at' => $faker->dateTime('now'),
      'updated_at' => $faker->dateTime('now'),
    ];
});
