<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
$factory->define(App\Permission::class, function (Faker $faker) {
  $actions = array("show", "create", "update", "delete", "manage");
  $action = $actions[array_rand($actions)];
  $model = $faker->word;
    return [
      'name' => $action . '-' . $model . $faker->randomNumber(6),
      'display_name' => ucfirst($action) . ' ' . $model,
      'description' => $faker->words(5, true),
      'created_at' => $faker->dateTime(),
    ];
});
