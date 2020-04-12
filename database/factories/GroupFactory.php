<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Group::class, function (Faker $faker) {
    $group_name = ucfirst(implode(' ', $faker->words));

    return [
      'name' => $group_name,
      'title' => Str::plural($group_name),
      'description' => 'Group of '.Str::plural($group_name),
      'is_active' => 1,
      'visibility' => 'User and User Admin Only',
      'is_hidden' => 0,
      'is_reserved' => 0,
      'created_id' => null,
      'deleted_at' => null,
      'remember_token' => Str::random(10),
      'created_at' => $faker->dateTimeBetween($startDate = '-12 days', $endDate = '-6 days'),
      'updated_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = '-1 days'),
    ];
});
