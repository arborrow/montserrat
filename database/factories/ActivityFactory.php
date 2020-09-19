<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Activity::class, function (Faker $faker) {
    return [
        'source_record_id' => $faker->randomNumber(),
        'activity_type_id' => $faker->randomNumber(),
        'subject' => $faker->word,
        'activity_date_time' => $faker->dateTime(),
        'duration' => $faker->randomNumber(),
        'location' => $faker->word,
        'phone_id' => $faker->randomNumber(),
        'phone_number' => $faker->phoneNumber,
        'details' => $faker->text,
        'status_id' => $faker->randomNumber(),
        'priority_id' => $faker->randomNumber(),
        'parent_id' => $faker->randomNumber(),
        'is_test' => $faker->boolean,
        'medium_id' => $faker->randomNumber(),
        'is_auto' => $faker->boolean,
        'relationship_id' => $faker->randomNumber(),
        'is_current_revision' => $faker->boolean,
        'original_id' => $faker->randomNumber(),
        'result' => $faker->word,
        'is_deleted' => $faker->boolean,
        'campaign_id' => $faker->randomNumber(),
        'engagement_level' => $faker->randomNumber(),
        'weight' => $faker->randomNumber(),
        'is_star' => $faker->boolean,
        'remember_token' => Str::random(10),
    ];
});
