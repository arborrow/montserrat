<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\AssetType::class, function (Faker $faker) {
    $label = $faker->word;

    return [
        'label' => $label,
        'name' => $label,
        'description' => $faker->sentence,
        'is_active' => 1,
        'parent_asset_type_id' => null,
        'created_at' => now(),
        'updated_at' => now(),
        'remember_token' => Str::random(10),
    ];
});
