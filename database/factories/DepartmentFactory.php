<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Department::class, function (Faker $faker) {
    $name = $faker->lastname.' of '.$faker->city;

    return [
        'name' => $name,
        'label' => $name,
        'description' => $faker->sentence,
        'notes' => $faker->text(100),
        'is_active' => 1,
        'parent_id' =>  null,
    ];
});
