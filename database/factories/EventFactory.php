<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

/*
 * Create generic events of various types
 * Start date will between plus or minus 60 days of today
 * End date will be 1 to 5 days after the start date
 * Title will be 2 words plus the word Retreat
 * Idnumber begins with 2018 and adds a random and unique 4 digit number
 */

$factory->define(App\Retreat::class, function (Faker $faker) {
    $start_date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());
    $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays($faker->numberBetween(1, 5));
    $title = ucwords(implode(' ', $faker->words(2))).' Retreat';
    $idnumber = (int) '2018'.$faker->unique()->randomNumber(4).'-'.$faker->unique()->lastName;
    // dd($start_date,$end_date);
    // dd($title, $start_date, $end_date, $idnumber);

    return [
        'title' => $title,
        'description' => $faker->sentence,
        'event_type_id' => $faker->numberBetween(1, 14),
        'start_date' => $start_date,
        'end_date' => $end_date,
        'is_active' => 1,
        'idnumber' =>  $idnumber,
    ];
});
