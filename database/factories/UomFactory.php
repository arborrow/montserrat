<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Uom::class, function (Faker $faker) {
    $label = $faker->word;
    $type = $faker->randomElement(config('polanco.uom_types'));
    $description = $label.' of '.$type;

    return [
        'unit_name' => $label,
        'unit_symbol' => $label,
        'type' => $type,
        'description' => $description,
        'is_active' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
