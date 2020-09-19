<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\ExportList::class, function (Faker $faker) {
    $label = $faker->word;
    $type = $faker->randomElement(config('polanco.export_list_types'));
    $start_date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());
    $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays($faker->numberBetween(1, 5));

    return [
        'title' => 'Title for '.$label,
        'label' => $label,
        'type' => $type,
        'fields' => 'Fields for '.$type,
        'filters' => 'Filters for '.$type,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'last_run_date' => $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
        'end_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 year', $timezone = null),
    ];
});
